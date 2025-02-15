import mysql.connector
import cv2
import face_recognition
import numpy as np
from datetime import datetime
import threading
import queue
import time

# Database connection
connection = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="universitydb"
)
cursor = connection.cursor()

# Function to fetch images and details from the database
def fetch_images_from_db(table_name):
    cursor.execute(f"SELECT * FROM {table_name}")
    records = cursor.fetchall()
    images = []
    details = []
    base_path = "D:\\xampp\\htdocs\\face_recognition_attendance\\"

    for row in records:
        image_relative_path = row[-1]  # Adjust according to your schema
        if isinstance(image_relative_path, bytes):
            image_relative_path = image_relative_path.decode()  # Decode bytes to string if necessary
        image_path = base_path + image_relative_path
        
        try:
            image = cv2.imread(image_path)
            if image is not None:
                images.append(image)
                details.append(row[:-1])  # Exclude image data from details
            else:
                print(f"Failed to read image from path: {image_path} for record: {row}")
        except Exception as e:
            print(f"Error reading image from path: {image_path} for record: {row}: {e}")
    
    return images, details

# Load student and teacher images
student_images, student_details = fetch_images_from_db("Student")
teacher_images, teacher_details = fetch_images_from_db("Teacher")

# Encode faces
def encode_faces(images):
    encoded_faces = []
    for image in images:
        if image is not None:
            rgb_image = cv2.cvtColor(image, cv2.COLOR_BGR2RGB)
            encodings = face_recognition.face_encodings(rgb_image)
            if encodings:
                encoded_faces.append(encodings[0])
    return encoded_faces

student_encodings = encode_faces(student_images)
teacher_encodings = encode_faces(teacher_images)

# Queue for passing frames from camera threads to attendance marking threads
frame_queue_camera1 = queue.Queue(maxsize=1)
frame_queue_camera2 = queue.Queue(maxsize=1)

# Function to capture frames from camera 1
def capture_frames_camera1():
    video_capture = cv2.VideoCapture(0)  # Assuming camera 1 is used
    try:
        while not should_stop_capture_camera1.is_set():
            ret, frame = video_capture.read()
            if not ret:
                print("Failed to capture frame from camera 1. Exiting.")
                break
            if not frame_queue_camera1.full():
                frame_queue_camera1.put(frame.copy())
            cv2.imshow('STudent Camera', frame)  # Display frame
            if cv2.waitKey(1) & 0xFF == ord('q'):
                break
    finally:
        video_capture.release()
        cv2.destroyAllWindows()

# Function to capture frames from camera 2
def capture_frames_camera2():
    video_capture = cv2.VideoCapture(1)  # Assuming camera 2 is used
    try:
        while not should_stop_capture_camera2.is_set():
            ret, frame = video_capture.read()
            if not ret:
                print("Failed to capture frame from camera 2. Exiting.")
                break
            if not frame_queue_camera2.full():
                frame_queue_camera2.put(frame.copy())
            cv2.imshow('Teacher Camera', frame)  # Display frame
            if cv2.waitKey(1) & 0xFF == ord('q'):
                break
    finally:
        video_capture.release()
        cv2.destroyAllWindows()

# Function to mark attendance
def mark_attendance(encodings, details, attendance_table, id_field, name_field, frame_queue, should_stop):
    marked_attendance = set()

    while not should_stop.is_set():
        try:
            frame = frame_queue.get(timeout=1)  # Get frame from queue
        except queue.Empty:
            continue

        # Detect faces in the frame
        rgb_frame = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
        face_locations = face_recognition.face_locations(rgb_frame)
        face_encodings = face_recognition.face_encodings(rgb_frame, face_locations)

        for face_encoding in face_encodings:
            matches = face_recognition.compare_faces(encodings, face_encoding)
            face_distances = face_recognition.face_distance(encodings, face_encoding)
            
            # Use np.min() to get the minimum distance
            min_distance = np.min(face_distances)
            best_match_index = np.argmin(face_distances)

            if matches[best_match_index] and min_distance < 0.6:  # Adjust threshold as needed
                person_details = details[best_match_index]
                id_value, name = person_details[:2]

                # Check if attendance has already been marked
                if id_value not in marked_attendance:
                    now = datetime.now()
                    attendance_date = now.strftime("%Y-%m-%d")
                    attendance_time = now.strftime("%H:%M:%S")

                    # Mark attendance in the database
                    cursor.execute(f"""
                        INSERT INTO {attendance_table} ({id_field}, {name_field}, attendance_date, attendance_time)
                        VALUES (%s, %s, %s, %s)
                    """, (id_value, name, attendance_date, attendance_time))

                    connection.commit()
                    marked_attendance.add(id_value)
                    print(f"Attendance marked for {name} in {attendance_table}")

# Create stop events for each thread
should_stop_capture_camera1 = threading.Event()
should_stop_capture_camera2 = threading.Event()
should_stop_mark_student_attendance = threading.Event()
should_stop_mark_teacher_attendance = threading.Event()

# Create and start threads for capturing frames from both cameras
camera_thread1 = threading.Thread(target=capture_frames_camera1)
camera_thread2 = threading.Thread(target=capture_frames_camera2)
camera_thread1.start()
camera_thread2.start()

# Create and start threads for marking attendance for students and teachers
student_thread = threading.Thread(target=mark_attendance, args=(student_encodings, student_details, "Student_Attendance", "student_usn", "student_name", frame_queue_camera1, should_stop_mark_student_attendance))
teacher_thread = threading.Thread(target=mark_attendance, args=(teacher_encodings, teacher_details, "Teacher_Attendance", "teacher_id", "teacher_name", frame_queue_camera2, should_stop_mark_teacher_attendance))
student_thread.start()
teacher_thread.start()

# Run threads for 5 minutes
time.sleep(65)  # 300 seconds = 5 minutes

# Set stop events to signal threads to exit
should_stop_capture_camera1.set()
should_stop_capture_camera2.set()
should_stop_mark_student_attendance.set()
should_stop_mark_teacher_attendance.set()

# Join threads (wait for them to finish)
camera_thread1.join()
camera_thread2.join()
student_thread.join()
teacher_thread.join()

# Close database connection
cursor.close()
connection.close()
