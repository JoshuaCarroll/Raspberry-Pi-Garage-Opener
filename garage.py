#!/usr/bin/env python

import RPi.GPIO as GPIO, time, sys

GPIO.setwarnings(False)
GPIO.setmode(GPIO.BCM)
GPIO.setup(22,GPIO.IN,pull_up_down=GPIO.PUD_UP)
GPIO.setup(18,GPIO.OUT)

status = ''
command = sys.argv[1]

if GPIO.input(22):
	status = 'open'
else:
	status = 'closed'

if (command == 'open' and status == 'closed'):
	print "Opening."
	GPIO.output(18,GPIO.LOW)
	time.sleep(0.5)
	GPIO.output(18,GPIO.HIGH)

if (command == 'close' and status == 'open'):
        print "Closing."
        GPIO.output(18,GPIO.LOW)
        time.sleep(20)
        GPIO.output(18,GPIO.HIGH)

if (command == 'force' and status == 'open'):
        print "Closing."
        GPIO.output(18,GPIO.LOW)
        time.sleep(20)
        GPIO.output(18,GPIO.HIGH)

if (command == 'status'):
	print status

GPIO.cleanup()
