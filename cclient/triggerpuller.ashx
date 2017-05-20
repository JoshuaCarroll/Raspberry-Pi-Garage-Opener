<%@ WebHandler Language="C#" Class="triggerpuller" %>

using System;
using System.Web;
using System.Net;
using System.Configuration;

public class triggerpuller : IHttpHandler {

    private string garageURL = ConfigurationManager.AppSettings["garageURL"].ToString();

    public void ProcessRequest (HttpContext context) {
        context.Response.ContentType = "text/plain";

        string strResponse = "";

        string strUrl = garageURL + "server.php";

        if (context.Request.QueryString["force"] == "true")
        {
            strUrl += "?force=true";
        }

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