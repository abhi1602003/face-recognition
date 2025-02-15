from typing import Final
from telegram import Update, ReplyKeyboardMarkup
from telegram.ext import (
    Application, CommandHandler, MessageHandler, filters, ContextTypes, ConversationHandler
)
import mysql.connector

TOKEN: Final = "7321892436:AAGLiq85Qc93THFgKl0B1p9W6M6Eh9rejuk"
BOT_USERNAME: Final = "@vkit_mini_project_bot"

# Database connection details
DB_HOST = 'localhost'
DB_USER = 'root'
DB_PASSWORD = ''
DB_NAME = 'UniversityDB'

# Define states for conversation handler
CHOOSING, GETTING_STUDENT_USN, GETTING_TEACHER_ID = range(3)

# Function to connect to the database
def connect_db():
    return mysql.connector.connect(
        host=DB_HOST,
        user=DB_USER,
        password=DB_PASSWORD,
        database=DB_NAME
    )

async def start_command(update: Update, context: ContextTypes.DEFAULT_TYPE):
    reply_keyboard = [['Student', 'Teacher']]
    await update.message.reply_text(
        'Welcome! Are you a student or a teacher?',
        reply_markup=ReplyKeyboardMarkup(reply_keyboard, one_time_keyboard=True)
    )
    return CHOOSING

async def choice(update: Update, context: ContextTypes.DEFAULT_TYPE):
    user_choice = update.message.text.lower()
    if user_choice == 'student':
        await update.message.reply_text('Please enter your USN:')
        return GETTING_STUDENT_USN
    elif user_choice == 'teacher':
        await update.message.reply_text('Please enter your Teacher ID:')
        return GETTING_TEACHER_ID
    else:
        await update.message.reply_text('Invalid choice. Please type "Student" or "Teacher".')
        return CHOOSING

async def get_student_usn(update: Update, context: ContextTypes.DEFAULT_TYPE):
    usn = update.message.text
    db = connect_db()
    cursor = db.cursor()
    cursor.execute("SELECT attendance_date, attendance_time FROM Student_Attendance WHERE student_usn = %s", (usn,))
    result = cursor.fetchone()
    if result:
        await update.message.reply_text(f'Attendance taken on: {result[0]} at {result[1]}')
    else:
        await update.message.reply_text('No attendance record found.')
    
    # Ensure all results are fetched before closing cursor and connection
    cursor.fetchall()  # This ensures any remaining results are consumed
    
    cursor.close()
    db.close()

    await end_conversation(update, context)
    return ConversationHandler.END

async def get_teacher_id(update: Update, context: ContextTypes.DEFAULT_TYPE):
    teacher_id = update.message.text
    db = connect_db()
    cursor = db.cursor()
    cursor.execute("SELECT attendance_date, attendance_time FROM Teacher_Attendance WHERE teacher_id = %s", (teacher_id,))
    result = cursor.fetchone()
    if result:
        await update.message.reply_text(f'Attendance taken on: {result[0]} at {result[1]}')
    else:
        await update.message.reply_text('No attendance record found.')
    
    # Ensure all results are fetched before closing cursor and connection
    cursor.fetchall()  # This ensures any remaining results are consumed
    
    cursor.close()
    db.close()

    await end_conversation(update, context)
    return ConversationHandler.END


async def end_conversation(update: Update, context: ContextTypes.DEFAULT_TYPE):
    await update.message.reply_text('The chat has ended. If you want to rechart, type /start.')

async def error(update: Update, context: ContextTypes.DEFAULT_TYPE):
    print(f'Update {update} caused error {context.error}')

if __name__ == '__main__':
    print('Starting bot...')
    application = Application.builder().token(TOKEN).build()

    conv_handler = ConversationHandler(
        entry_points=[CommandHandler('start', start_command)],
        states={
            CHOOSING: [MessageHandler(filters.TEXT & ~filters.COMMAND, choice)],
            GETTING_STUDENT_USN: [MessageHandler(filters.TEXT & ~filters.COMMAND, get_student_usn)],
            GETTING_TEACHER_ID: [MessageHandler(filters.TEXT & ~filters.COMMAND, get_teacher_id)]
        },
        fallbacks=[]
    )

    application.add_handler(conv_handler)
    application.add_error_handler(error)

    print('Polling...')
    application.run_polling(poll_interval=5)
