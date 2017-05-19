#! /bin/bash
# /etc/init.d/garagerelay

### BEGIN INIT INFO
# Provides:          garagerelay
# Required-Start:    $remote_fs $syslog
# Required-Stop:     $remote_fs $syslog
# Default-Start:     4 5
# Default-Stop:      0 1 2 3 6
# Short-Description: Start garage door control daemon at boot time
# Description:       Enable service provided by garage door daemon.
### END INIT INFO

# To install, do this :
# sudo cp garagerelay.sh /etc/init.d/garagerelay
# sudo chmod 777 /etc/init.d/garagerelay
# sudo update-rc.d -f garagerelay start 4



# Carry out specific functions when asked to by the system
case "$1" in
start)
echo "Starting Relay"
# Turn 18 on which keeps relay off, then init relay
/usr/local/bin/gpio -g write 18 1
/usr/local/bin/gpio -g mode 18 out

#Initialize door monitor
/usr/local/bin/gpio -g mode 22 in
/usr/local/bin/gpio -g mode 22 up

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