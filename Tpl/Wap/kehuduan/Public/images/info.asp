<!DOCTYPE html>
<html class="ui-mobile">
<head>
<!--#include file="inc/getHeader.asp"-->
<!--#include file="inc/config.asp"-->
<meta http-equiv="Content-Type" content="<%=header%>; charset=utf-8">
<title><%=siteName%></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="MobileOptimized" content="240">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
<link rel="apple-touch-icon" href="images/appico.png"/>
<link rel="stylesheet" href = "css/style.css">
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/huaping.js"></script>
<script type="text/javascript" src="js/sj_function.js"></script>
<!--#include file="inc/db_conn.asp"-->
<!--#include file="inc/func.asp"-->
<%
id=trim(request.QueryString("id"))
if id<>"" and isnumeric(id) then 
else
  if trim(InfoOneId)<>"" then
    id=InfoOneId
  else
    id=2
  end if
end if
   id=cint(id)
   sql="select title,content,sjcontent,infoclass from info where id=" & id & ""
   Set rs= Server.CreateObject("ADODB.Recordset")
   rs.open sql,conn,1,1
   if rs.bof and rs.eof then
      Response.redirect "index.asp"
      response.End
   else	
	  title=rs("title")
	  sjcontent=rs("sjcontent")
	  content=rs("content")
		infoclass=rs("infoclass")
   end if
   rs.close
   set rs=nothing
%>
</head>

<body>
<script type="text/javascript" src="js/getBodyAuto.js"></script>
<div data-role="page" id="shownews" class="main_box">
<!--#include file="head1.asp" -->
   <div data-role="header">
    <header class="headerNews">
      <span class="return fl" onClick="javascript:history.go(-1);">
        <div class="btn">
            <b>
            <em></em>
            </b>
            <span> 返回 </span>
        </div>
      </span>
      <span class="BigclassName"><%=gotTopic(trim(title),12)%></span>
      <span class="rightButton fr">
        <span class="titleBar fr" role="Bar_Left">
          <em class="kinds"> 导航 </em>
          <em class="icon"></em>
        </span>
      <span class="textSizeBtn" style="position: relative;">
            <em class="title">字<sup> + </sup></em>
            <div class="textSize" style="display: none;">
              <div class="contArrow">
                <em>◆</em>
                <i>◆</i>
               </div>
               <ul class="cont">
                 <li style="font-size:12px;"> 小 </li>
                 <li style="font-size:14px;" class="current"> 中 </li>
                 <li style="font-size:16px;"> 大 </li>
               </ul>
            </div>
         </span>
      </span>
      <div class="clear"></div>
    </header>
  </div>
    <article class="News-detail">
       <div class="News-articleCont">
         <% If sjcontent<>""  Then %><%= sjcontent %><% Else %><%=UploadFiles(content)%><% End If %>
       </div>
    </article> 
<!--#include file="inc/box_nav.asp" -->
<!--#include file="foot.asp" -->
</div>
<!--#include file="download.asp" -->
</body>
</html>
