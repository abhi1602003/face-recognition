import subprocess
import time

# Define the scripts and their corresponding delays (in seconds)
scripts_and_delays = [
    ("attendance_system.py", 0),         # Run 'face_recognition.py' and wait 0 seconds (no delay, will wait for completion)
    ("sever-to-excel.py", 2),           # Run 'sever-to-excel.py' and wait 2 seconds
    ("add_91_excel.py", 2),             # Run 'add_91_excel.py' and wait 2 seconds
    ("open_whatappweb.py", 15),         # Run 'open_whatappweb.py' and wait 15 seconds
    ("whatapp_auto_message.py", 0),    # Run 'whatapp_auto_message.py' (no delay, will wait for completion)
    # No delay between 'whatapp_auto_message.py' and 'telegram_bot.py'
    ("telegram_bot.py", 2 * 60 * 60)   # Run 'telegram_bot.py' and wait 2 hours (7200 seconds)
]
# Function to run a script and wait for the specified delay
def run_script(script, delay):
    try:
        # Start the script
        result = subprocess.run(["python", script], check=True)
        # Print the result of the script execution
        print(f"Executed {script} with return code {result.returncode}. Waiting for {delay} seconds...")
        # Wait for the specified delay
        if delay > 0:
            time.sleep(delay)
    except subprocess.CalledProcessError as e:
        # Print an error message if the script fails
        print(f"An error occurred while running {script}: {e}")

# Process each script with the corresponding delay
for script, delay in scripts_and_delays:
    run_script(script, delay)

print("All scripts have been executed.")
