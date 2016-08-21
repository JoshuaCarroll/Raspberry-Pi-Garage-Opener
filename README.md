# Raspberry-Pi-Garage-Opener

This project is based on/inspired by the Instructables article by quartarian at [http://www.instructables.com/id/Raspberry-Pi-Garage-Door-Opener](http://www.instructables.com/id/Raspberry-Pi-Garage-Door-Opener).

Once you assemble the hardware as described in his article, simply follow these steps to install the software:

# Installation

1. Install Apache2, PHP5, and the PHP module for Apache with the following command:

    `sudo apt-get install apache2 php5 libapache2-mod-php5 -y`

2. Navigate to the web folder:

    `cd /var/www/html`

3. Download the files to a folder named `garage` (assuming you want to use your Pi for additional projects):

    `sudo git clone https://github.com/JoshuaCarroll/Raspberry-Pi-Garage-Opener.git garage`
  
4. Return to the dashboard site root.

    `cd garage`

You should now be in `/var/www/html/garage`

5. Update scripts to match your hardware. In the Instructables article the author used GPIO 7, however I was already using that port so I used GPIO 18. If you do not want to use GPIO 18, here are the files you'll need to update. Just type `nano filename` to edit these files.

    - garagerelay.sh 
    - trigger.php

6. Run these commands to install the startup script:

    ```
    sudo cp garagerelay.sh /etc/init.d/garagerelay
    sudo chmod 777 /etc/init.d/garagerelay
    sudo update-rc.d -f garagerelay start 4
    ```

7. Copy and set permissions for the status file.

    ```
    cp status.txt /home/pi/status.txt
    chown www-data:www-data /home/pi/status.txt 
    chmod 777 /home/pi/status.txt
    ```

### Connect and test

1. Find your Raspberry Pi's IP address:

    `ifconfig`
  
    The IP address will be on the second line just after `inet addr:`. 

2. Enter this IP address into a browser followed by `/garage`. For example:

    `http://192.168.1.4/garage`
    
3. Close the garage. This project will *try* to keep up with, and display, the status of your garage door. But it's pretty dumb - it assumes that the door is closed on first use and simply alternates that value.

4. Try it out. If you have everything assembled correctly it should work like a champ.