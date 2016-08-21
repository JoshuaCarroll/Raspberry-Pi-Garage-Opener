#! /bin/bash
# /etc/init.d/garagerelay

# Install with: 
#  sudo cp garagerelay.sh /etc/init.d/garagerelay
#  sudo chmod 777 /etc/init.d/garagerelay
#  sudo update-rc.d -f garagerelay start 4

# Carry out specific functions when asked to by the system
case "$1" in
start)
echo "Starting Relay"

# Turn 18 on which keeps relay off
/usr/local/bin/gpio -g write 18 off

#Start Gpio
/usr/local/bin/gpio -g mode 18 out
;;

stop)
echo "Stopping gpio"
;;
*)
echo "Usage: /etc/init.d/garagerelay {start|stop}"
exit 1
;;

esac
exit 0