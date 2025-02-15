import subprocess

# Path to XAMPP control script
xampp_control_path = r"D:\xampp\xampp_stop.exe"

# Command to start XAMPP
start_command = [xampp_control_path]

# Execute the command to start XAMPP
subprocess.run(start_command, shell=True)

# Path to MySQL control script
mysql_control_path = r"D:\xampp\mysql_stop.bat"

# Command to start MySQL
start_mysql_command = [mysql_control_path]

# Execute the command to start MySQL
subprocess.run(start_mysql_command, shell=True)
