using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

public partial class cclient_Default : System.Web.UI.Page
{
    protected void Page_Load(object sender, EventArgs e)
    {
        if ((Request.Cookies["u"] != null) && (Request.Cookies["p"] != null) && (Request.Cookies["name"] != null))
        {
            string user = Request.Cookies["u"].Value;
            string pass = Request.Cookies["p"].Value;
            string name = Request.Cookies["name"].Value;

            lblLogin.Text = "<input type='hidden' id='txtUsername' name='username' value='" + user + "'>&nbsp;";
            lblLogin.Text += "<input type='hidden' id='txtPassword' name='password' value='" + pass + "'>&nbsp;";
            lblName.Text = "<span id=\"spnName\">" + name + "&nbsp;</span><button id='btnLogout' onclick='logout()'>Logout</button>";
        }
        else
        {
            lblLogin.Text = "<input placeholder=\"Username\" type=\"text\" id=\"txtUsername\" name=\"username\">&nbsp;";
            lblLogin.Text += "<input placeholder=\"Password\" type=\"password\" id=\"txtPassword\" name=\"password\">";
        }
    }
}