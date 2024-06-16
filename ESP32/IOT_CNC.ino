#include <WiFi.h>
#include <HTTPClient.h>
#include <ArduinoJson.h>
//Gloable
String body, PostRequestUrl, tokenData;
int httpResponseCode;
// Wi-Fi Credentials
const char* ssid = "Ahmed";
const char* password = "12345678910";
WiFiClient client;
HTTPClient http;
IPAddress staticIP(192, 168, 43, 62);
IPAddress gateway(192, 168, 43, 213);
IPAddress subnet(255, 255, 255, 0);
IPAddress dns(192, 168, 43, 123);
void setup()
{
Serial.begin(115200);
delay(1000);
if (WiFi.config(staticIP, gateway, subnet, dns, dns) == false) 
{
  Serial.println("Configuration failed.");
}
// Serial.println("\n\nConecting\n");
setup_wifi();
}
void loop() 
{
  //Check WiFi connection
  if (WiFi.status() == WL_CONNECTED) 
  {
    //Auth POST
    PostRequestUrl = "http://192.168.43.213:8000/api/apiLogin";
    http.begin(client, PostRequestUrl);
    http.addHeader("content-Type", "application/json");
    body = "{\"name\":\"ahmed\",\"password\":\"123456\"}";
    httpResponseCode = http.POST(body);
    tokenData = http.getString();
    StaticJsonDocument<200> doc;
    DeserializationError error = deserializeJson(doc, tokenData);
    String token = doc["token"];
    http.end();  
    //Data GET
    const String requestUrl = "http://192.168.43.213:8000/api/signatures";
    http.begin(client, requestUrl);
    http.addHeader("Authorization", "Bearer " + token);
    httpResponseCode = http.GET();
    String GETpayload = http.getString();
    http.end();
    if (httpResponseCode == HTTP_CODE_OK) 
    {
      DynamicJsonDocument doc(1024);
      deserializeJson(doc, GETpayload);
      JsonObject obj = doc.as<JsonObject>();
      String id = obj[String("data")][String("id")];
      String realTimeInfo = obj[String("data")][String("realTimeInfo")];
      String settings_value = obj[String("data")][String("settings_value")];
      if (realTimeInfo == "3") 
      {
        Serial.println("$110=" + settings_value);
        Serial.println("$111=" + settings_value);
        Serial.println("$112=" + settings_value);
        // POST
        PostRequestUrl = "http://192.168.43.213:8000/api/signatures/" + id;
        http.begin(client, PostRequestUrl);
        http.addHeader("content-Type", "application/json");
        http.addHeader("Authorization", "Bearer " + token);
        body = "{\"state\":\"end Proccing\",\"code\":\"3\"}";
        httpResponseCode = http.POST(body);
        http.end();  
      } else if (realTimeInfo == "4") 
      {
        Serial.println("$120=" + settings_value);
        Serial.println("$121=" + settings_value);
        Serial.println("$122=" + settings_value);
        // POST
        PostRequestUrl = "http://192.168.43.213:8000/api/signatures/" + id;
        http.begin(client, PostRequestUrl);
        http.addHeader("content-Type", "application/json");
        http.addHeader("Authorization", "Bearer " + token);
        body = "{\"state\":\"end Proccing\",\"code\":\"4\"}";
        httpResponseCode = http.POST(body);
        http.end();  
      } else 
      {
        //array
        JsonArray signatureFileContentArray = obj[String("data")][String("signatureContent")];
        // POST
        PostRequestUrl = "http://192.168.43.213:8000/api/signatures/" + id;
        http.begin(client, PostRequestUrl);
        http.addHeader("content-Type", "application/json");
        http.addHeader("Authorization", "Bearer " + token);
        body = "{\"state\":\"Get Req Recived, Proccing\",\"code\":\"1\"}";
        httpResponseCode = http.POST(body);
        http.end();
        for (JsonVariant value : signatureFileContentArray) 
        {
          String signatureValue = value.as<String>();
          Serial.println(signatureValue);
          int Speed = 500;//mm per min as a min speed + Assuming that the acceleration is zero
          int xIndex, yIndex;
          float a_delay, initialXValue, initialYValue, xValue, yValue, deltaX, deltaY;
          xIndex = signatureValue.indexOf('X');
          yIndex = signatureValue.indexOf('Y');    
          //Extract X and Y values if 'X' and 'Y' are found
          if (xIndex != -1 && yIndex != -1) 
          {
            xValue = getValue(signatureValue, xIndex);
            yValue = getValue(signatureValue, yIndex);
            deltaX = xValue - initialXValue;
            deltaY = yValue - initialYValue;
            if (deltaX > deltaY && deltaX > 0.500 && deltaX < -0.500)
            {
              deltaY = (float)(deltaX / Speed) * 60; 
            } else if(deltaY > deltaX && deltaY > 0.500 && deltaY < -0.500)
            {
              deltaY = (float)(deltaY / Speed ) * 60;
            } else 
            {
              a_delay = 50;   
            }
            delay(a_delay);        
          } else
          {
            delay(300);
          }
          initialXValue = xValue;
          initialYValue = yValue;
        }
      PostRequestUrl = "http://192.168.43.213:8000/api/signatures/" + id;
      http.begin(client, PostRequestUrl);
      http.addHeader("content-Type", "application/json");
      http.addHeader("Authorization", "Bearer " + token);
      body = "{\"state\":\"end Proccing\",\"code\":\"2\"}";
      httpResponseCode = http.POST(body);
      http.end();  
      }
    } else 
    {
      Serial.print("Error code: ");
      Serial.println(httpResponseCode);
    }
  } else 
  {
    Serial.println("WiFi Disconnected!!");
  }
delay(15000);
}
void setup_wifi() 
{
  // Serial.print("Connecting to:");
  // Serial.println(ssid);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) 
  {
    delay(500);
    // Serial.print(".");
  }
  // Serial.println("WiFi connected");
  // Serial.println("IP address: ");
  // Serial.println(WiFi.localIP());
}
float getValue(String command, int startIndex) 
{
  // Find the index of the first non-numeric character after the target character
  int endIndex = startIndex + 1;
  while (endIndex < command.length() && (isdigit(command.charAt(endIndex)) || command.charAt(endIndex) == '.')) 
  {
    endIndex++;
  }
  // Extract the substring containing the numerical value
  String valueStr = command.substring(startIndex + 1, endIndex);
  // Convert the substring to a float value
  return valueStr.toFloat();
}