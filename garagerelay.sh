#! /bin/bash
# /etc/init.d/garagerelay
### BEGIN INIT INFO
# Provides:          garagerelay
# Required-Start:    $local_fs $network
# Required-Stop:     $local_fs
# Default-Start:     2 3 4 5
# Default-Stop:      0 1 6
# Short-Description: garagerelay
# Description:       Garage relay service
### END INIT INFO

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