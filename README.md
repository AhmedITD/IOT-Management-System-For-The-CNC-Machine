IOT management System For The CNC machine

Management System:
you can with this system do an Auth by login with the user seed then start creating new accountes as needed
after that you can create, Edite, Delete Gcode files in order to send it to your CNC machine
with fill Monitoring system So you can know what is your CNC machine is doing at the moment
and at last you can set the Speed and the Accelerating of your CNC machine as you want with this system by limited number.
Note: This system has a good vaildtion but not 100% vaildtion as a holl project build with in tow weekes
       So it mate be some errores or gapes.
The user seed:
user name: ahmed
password: 123456

IOT:
ESP32<---------->Management System
in the IOT system you sould conecting the unit that you goona use it as a managment system unit
to the same wifi that you goona connect your ESP32 as i used it as a transmitter and a receiver unit from and to the CNC machine and the Management system
The ESP32 goona handle all the requstes with the internet and sendding the commandes to the CNC machine.
The defalut wifi connection is: 
ssid:Ahmed
password:12345678910

CNC:
you can use any type of CNC machine that you want to as well as the other CNC machine proprties,
i used: Polter CNC with CORE_XY, A4 Size, 2 Stepers Motores for X and Y with One Servo Motor for the Z, arduino with CNC shiled
And with grbl framwork as a software. 

Communication:
CNC<------------Serial Communication----------->ESP32
ESP32<----------IOT---------->Management System
Local Server on The WIFI
IP address
Server IP:192.168.43.213
ESP32 IP:192.168.43.62
The ESP32 IP must match For security purposes.

So at last i do't thing that im goona update this project becase the project was not too important to me as it's vision for the bigger projectes so i wanted this project just to work at any cost,
So you can update this project and make it usefull for you in any way you want.

if you was interested about project's vision:
in this project we proved there is a big chance that we can build an Automated online Stores what ever manufacturing it has like a personal store 
or an robotic restaurants or a smart darkstores with its too many applcations today or Factories and any think was its goal to make the world more Automated.
