#!/bin/bash

gpioReedSwitch=22
gpioSwitch=18
secondsNeededToClose=20

gpio -g write $gpioSwitch on
gpio -g mode $gpioSwitch out
gpio -g mode $gpioReedSwitch in
gpio -g mode $gpioReedSwitch up

status=''
command=$1

status=$(gpio -g read $gpioReedSwitch)

if [ "$status" == "1" ]
then
	status='open'
else
	status='closed'
fi

if [ "$command" == "open" ] && [ "$status" == 'closed' ]
then
	gpio -g write $gpioSwitch off
	sleep 0.7
	gpio -g write $gpioSwitch on
fi

if [ "$command" == "close" ] && [ "$status" == "open" ]
then
        gpio -g write $gpioSwitch off
        sleep 0.7
        gpio -g write $gpioSwitch on
fi

if [ "$command" == "force" ] && [ "$status" == "open" ]
then
        gpio -g write $gpioSwitch off
        sleep $secondsNeededToClose
        gpio -g write $gpioSwitch on
fi

if [ "$command" == "buttonDown" ]
then
	gpio -g write $gpioSwitch off
fi

if [ "$command" == "buttonUp" ]
then
        gpio -g write $gpioSwitch on
fi

echo "$status"
