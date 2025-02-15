import pandas as pd

# Function to add +91 prefix if not already present
def add_prefix(phone_number):
    return phone_number if str(phone_number).startswith('+91') else f'+91 {phone_number}'

# List of Excel file paths and the corresponding columns to process
files_and_columns = [
    (r'D:\mahesh2003\mini_project\face_recognition_attendance\sever-to-excel\student_attendance.xlsx', 'student_phone'),  # Replace 'Phone' with the actual student phone column
    (r'D:\mahesh2003\mini_project\face_recognition_attendance\sever-to-excel\teacher_attendance.xlsx', 'teacher_phone')  # Replace 'Contact' with the actual teacher phone column
]

# Process each file
for file_path, phone_column in files_and_columns:
    # Read the Excel file into a DataFrame
    df = pd.read_excel(file_path)

    # Add the +91 prefix to each phone number if not already present
    df[phone_column] = df[phone_column].apply(add_prefix)

    # Save the modified DataFrame back to the original Excel file
    df.to_excel(file_path, index=False)

    print(f"Processed and saved: {file_path}")
