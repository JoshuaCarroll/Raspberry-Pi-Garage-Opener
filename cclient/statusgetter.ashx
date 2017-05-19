<%@ WebHandler Language="C#" Class="statusgetter" %>

using System;
using System.Web;
using System.Net;

public class statusgetter : IHttpHandler {

    private string garageURL = "http://n5jlc.duckdns.org:81/dev/";
    
    public void ProcessRequest (HttpContext context) {
        context.Response.ContentType = "text/plain";
        
        string strUrl = garageURL + "status.php";
        string strResponse = "";
        
        using (WebClient client = new WebClient())
        {
            strResponse = client.DownloadString(strUrl);
        }

        context.Response.Write(strResponse);
    }
 
    public bool IsReusable {
        get {
            return false;
        }
    }

}