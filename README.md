# Quinyx Sales Forecasts

A service that given a geographical position, a sales forecast and the weather forecast returns the updated sales forecast using a set of given rules. The service reads in an xlsx file for dates and corresponding sales forecasts, gets the weather forecasts for a given geographical position then updates sales forecasts for the dates that have a corresponding weather forecast.

Installation
Download and unpack files into domain root. For example http://workpad.webdemos.co.za/

DEMO:

http://workpad.webdemos.co.za/lat/60.555/lon/24/sales-forecast.html

http://workpad.webdemos.co.za/lat/60.555/lon/24/sales-forecast.json

How to use:

The service has 2 formats, json and html:

JSON: 

Make an http call to /lat/60.555/lon/24/sales-forecast.json

Geographical position is supplied as parameters in the URL. In this case, latitude=60.555 and longitude=24

Returns a JSON encoded array with values [Date, Initial Forecast, Updated Forecast, Temperature, Average Rainfall]

HTML:
 
Make an http call to /lat/60.555/lon/24/sales-forecast.html

Geographical position is supplied as parameters in the URL. In this case, latitude=60.555 and longitude=24

Displays a table with values [Date, Initial Forecast, Updated Forecast, Temperature, Average Rainfall]


Assumptions:
1. Sales forecast date values should be greater than the present date/time, so the service will ignore any past dates and returns updated forecasts at 0
2. MOD REWRITE is enabled to allow .htaccess routing


