import pandas as pd
import pywhatkit as kit
import time  # Import the time module

# Function to send WhatsApp message immediately
def send_whatsapp_message(phone_number, message):
    try:
        # Sending message immediately
        kit.sendwhatmsg_instantly(phone_number, message, wait_time=15, tab_close=True, close_time=10)
        print(f"Message sent successfully to {phone_number}!")
        time.sleep(10)  # Delay to ensure that the message is sent properly before closing the tab
    except Exception as e:
        print(f"Failed to send message to {phone_number}. Error: {str(e)}")

# Function to send bulk WhatsApp messages immediately
def send_bulk_whatsapp_messages(phone_numbers, messages):
    for number, message in zip(phone_numbers, messages):
        send_whatsapp_message(number, message)

# Function to read student details from Excel
def read_student_details_from_excel(file_path, sheet_name):
    try:
        df = pd.read_excel(file_path, sheet_name=sheet_name)
        student_details = df[['student_phone', 'student_name', 'student_usn', 'attendance_date', 'attendance_time']].dropna().astype(str).to_dict('records')
        return student_details
    except Exception as e:
        print(f"Error reading Excel file: {str(e)}")
        return []

# Function to read teacher details from Excel
def read_teacher_details_from_excel(file_path, sheet_name):
    try:
        df = pd.read_excel(file_path, sheet_name=sheet_name)
        teacher_details = df[['teacher_phone', 'teacher_name', 'teacher_id', 'attendance_date', 'attendance_time']].dropna().astype(str).to_dict('records')
        return teacher_details
    except Exception as e:
        print(f"Error reading Excel file: {str(e)}")
        return []

# Example usage
if __name__ == "__main__":
    # Excel file paths and details
    student_excel_file = r"D:\mahesh2003\mini_project\face_recognition_attendance\sever-to-excel\student_attendance.xlsx"
    teacher_excel_file = r"D:\mahesh2003\mini_project\face_recognition_attendance\sever-to-excel\teacher_attendance.xlsx"
    
    student_excel_sheet = "Sheet1"  # Correct sheet name for student data
    teacher_excel_sheet = "Sheet1"  # Correct sheet name for teacher data
    
    # Read teacher details from Excel
    teacher_details = read_teacher_details_from_excel(teacher_excel_file, teacher_excel_sheet)
    
    if teacher_details:
        # Prepare messages for teachers
        teacher_phone_numbers = [detail['teacher_phone'] for detail in teacher_details]
        teacher_messages = [
            f"{detail['teacher_name']} {detail['teacher_id']} you attended as taken {detail['attendance_date']} {detail['attendance_time']}"
            for detail in teacher_details
        ]
        
        # Send the WhatsApp messages to teacher recipients immediately
        send_bulk_whatsapp_messages(teacher_phone_numbers, teacher_messages)
        print("Messages sent to teachers.")
        time.sleep(10)
        # Read student details from Excel
        student_details = read_student_details_from_excel(student_excel_file, student_excel_sheet)
        
        if student_details:
            # Prepare messages for students
            student_phone_numbers = [detail['student_phone'] for detail in student_details]
            student_messages = [
                f"{detail['student_name']} {detail['student_usn']} you attended as taken {detail['attendance_date']} {detail['attendance_time']}"
                for detail in student_details
            ]
            
            # Send the WhatsApp messages to student recipients immediately
            send_bulk_whatsapp_messages(student_phone_numbers, student_messages)
            print("Messages sent to students.")
            time.sleep(10)
        else:
            print("No student details found in the Excel sheet.")
    else:
        print("No teacher details found in the Excel sheet.")
