import os
import mysql.connector
import pandas as pd
import threading
from datetime import datetime

# Database connection details
db_config = {
    'host': 'localhost',
    'user': 'root',
    'password': '',
    'database': 'UniversityDB'
}

# Function to fetch data from MySQL and save to Excel
def export_attendance_to_excel(output_path):
    try:
        # Connect to the database
        conn = mysql.connector.connect(**db_config)
        cursor = conn.cursor()

        # Get the current date
        current_date = datetime.now().strftime('%Y-%m-%d')

        # Fetch data from Student_Attendance joining with Student table for the current date
        student_query = f'''
        SELECT sa.student_usn, s.student_name, s.student_phone, DATE(sa.attendance_date), TIME_FORMAT(sa.attendance_time, '%H:%i:%s')
        FROM Student_Attendance sa
        JOIN Student s ON sa.student_usn = s.student_usn
        WHERE DATE(sa.attendance_date) = '{current_date}'
        '''
        cursor.execute(student_query)
        student_data = cursor.fetchall()

        # Fetch data from Teacher_Attendance joining with Teacher table for the current date
        teacher_query = f'''
        SELECT ta.teacher_id, t.teacher_name, t.teacher_phone, DATE(ta.attendance_date), TIME_FORMAT(ta.attendance_time, '%H:%i:%s')
        FROM Teacher_Attendance ta
        JOIN Teacher t ON ta.teacher_id = t.teacher_id
        WHERE DATE(ta.attendance_date) = '{current_date}'
        '''
        cursor.execute(teacher_query)
        teacher_data = cursor.fetchall()

        # Close database connection
        cursor.close()
        conn.close()

        # Convert fetched data to pandas DataFrames
        student_df = pd.DataFrame(student_data, columns=['student_usn', 'student_name', 'student_phone', 'attendance_date', 'attendance_time'])
        teacher_df = pd.DataFrame(teacher_data, columns=['teacher_id', 'teacher_name', 'teacher_phone', 'attendance_date', 'attendance_time'])

        # Save files to specific directory
        output_directory = output_path
        if not os.path.exists(output_directory):
            os.makedirs(output_directory)

        student_file = os.path.join(output_directory, 'student_attendance.xlsx')
        teacher_file = os.path.join(output_directory, 'teacher_attendance.xlsx')

        with pd.ExcelWriter(student_file) as writer:
            student_df.to_excel(writer, index=False, sheet_name='Student Attendance')

        with pd.ExcelWriter(teacher_file) as writer:
            teacher_df.to_excel(writer, index=False, sheet_name='Teacher Attendance')

        print(f"Attendance exported successfully to {student_file} and {teacher_file}")

    except mysql.connector.Error as err:
        print(f"Error: {err}")
    finally:
        if 'conn' in locals() and conn.is_connected():
            conn.close()

# Function to handle timeout
def timeout_handler():
    print("Timeout: Script execution took too long.")
    import sys
    sys.exit()

# Main function
if __name__ == '__main__':
    # Set the timeout period (in seconds)
    timeout_seconds = 60

    # Create a timer that calls timeout_handler after timeout_seconds
    timer = threading.Timer(timeout_seconds, timeout_handler)

    try:
        # Start the timer
        timer.start()

        # Specify the output directory where Excel files should be saved
        output_directory = 'D:\\mahesh2003\\mini_project\\face_recognition_attendance\\sever-to-excel'  # Replace with your desired path

        # Execute the function with the specified output directory
        export_attendance_to_excel(output_directory)

    finally:
        # Cancel the timer if function execution finishes before timeout
        timer.cancel()