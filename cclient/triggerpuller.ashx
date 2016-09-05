<%@ WebHandler Language="C#" Class="triggerpuller" %>

using System;
using System.Web;
using System.Net;

public class triggerpuller : IHttpHandler {
    
    public void ProcessRequest (HttpContext context) {
        context.Response.ContentType = "text/plain";

        string user = "";
        string pass = "";
        string strResponse = "";

        if ((context.Request.Cookies["u"] != null) && (context.Request.Cookies["p"] != null))
        {
            user = context.Request.Cookies["u"].Value;
            pass = context.Request.Cookies["p"].Value;
        }
        else if ((context.Request.QueryString["u"] != null) && (context.Request.QueryString["p"] != null))
        {
            user = context.Request.QueryString["u"];
            pass = context.Request.QueryString["p"];
        }

        string strUrl = Settings.garageURL + "trigger.php?u=" + user + "&p=" + pass;

        using(WebClient client = new WebClient()) {
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