��    I      d  a   �      0  
   1     <  �   K    �  W   �     D  X   [  (   �  z  �  O   X
  j   �
  p     *   �     �     �     �     �     �       	   
  	     m     �   �  �     
   �  %   �     �     �     �               -  4   J  F     Y   �        V   )  C   �  <   �                    *  #   8  
   \     g     �     �  "   �  $   �  �   �     �  	   �  
   �     �      �  l   �     c  2   i     �     �  	   �  �   �  	   �  [   �  J   �     8  �   G     �  C      +   D  *   p  F  �  
   �     �  �   �    �  W   �     �  X     (   e  z  �  O   	  j   Y  p   �  *   5     `     }     �     �     �     �  	   �  	   �  m   �  �   =  �   �  
   [  %   f     �     �     �     �     �     �  4   �  F   0  Y   w     �  V   �  C   1   <   u      �      �      �      �   �  �   
   n$     y$     �$     �$  "   �$  $   �$  �   %     �%  	   �%  
   �%     �%      �%  l   &     u&  2   {&     �&     �&  	   �&  �   �&  	   �'  [   �'  J   �'     J(  �   Y(     �(  C   )  +   V)  *   �)                   %   @   I   $   &   F      ;                 2   5       E   )      =   G   0          ,   C                 <          4                        #      !   +   /                       3   "       D       6                ?      
   7           (      1         .          	   A   8       :   9   H   B           >           *   -      '       '@+user+:' '@+user+blank' 1. Content in the form beneath is the output of function mailtocommenter_description(). Checked will diplay the following description under comment form. 2. You also can specify the position of description. To do this, please keep option unchecked and place <span style="background-color:#EDEDFF">&lt;?php if(function_exists('mailtocommenter_description')) mailtocommenter_description();?&gt;</span> into theme file. <b>Advice:</b> Simply click Preview button to see the mail content style while editing. <b>Button display</b>: <b>Button title display</b>, content which displayed when user hovers mouse over button: <b>Content generated by click button</b> <b>Note:</b> Commenter is allowed to use <b>'@User+blank'</b> to automatically notify your reply to other commenter. e.g, if ABC is one of commenter of this post, then write '@ABC '(exclude ') will automatically send your comment to ABC. Using '@all ' to notify all previous commenters. Be sure that the value of User should exactly match with commenter's name (case sensitive). <b>Note:</b><br/>1. Again, be sure the value of %rss_link% is correctly placed. <b>Note</b>: User can use this section to test whether your wordpress works well with mail sending or not. <br/>2. If your <b>mail service doesn't provide html format message</b>, please remove all html tag in template. @Reply style. i.e, @<a href="#">User </a>. Activate '@all ' or '@all:'. Activate mail notification. Address: Admin Admin email Anyone Blog link Blog name Checked will allow Wordpress to automatically send mail if comment content contains following specified code. Checked will allow user to use @all or @all: to send comment to all previous commenter. This option may make mail inundant to commenter. Checked will copy send last mail content with the sending result indicated to admin. Be sure that activate mail notification option must be checked. Code type: Comment author, the one insert @user  Comment link Comment time Configuration updated. Content: Customize Button style: Default configuration loaded Default display. @ image in plugin folder with link. Display following description under comment form. Html code supported. Display nothing. i.e, @user will be encapsulated by html comment code &lt;!-- and --&gt;. Example: Hyperlink. Link targets to the comment you want to reply. e.g, <a href="#">@User </a>. Keep configurations of Mail To Commenter while plugin deactivation. Language setting updated. Waiting for page to be reloaded... Load default Mail Content: Mail Subject: Mail Template Mail content in different languages Mail sent. Meaning of predefined variables Notify Admin. Notify this pumpkin. Permission for using @all or @all: Permission to use mail notification: Place <span style="background-color:#EDEDFF">&lt;?php if(function_exists('mailtocommenter_button')) mailtocommenter_button();?&gt;</span> into theme file to display button. Plain text. e.g, @user . Post link Post title Preview RSS link display, default is RSS RSS link, please specify your rss link since most people use third party (feedburner/feedsky) to manage rss. Reply Reply comment, comment of the one who insert @user Select Language:  Send Send Mail Specify the output of function mailtocommenter_button(). Html code supported. Default is to use notify.png image file in plugin folder, you can specify other image file or use plain text, like [reply]: Subject:  This section configures the style of button generated by function mailtocommenter_button(). Unchecked will automatically remove all associated settings from database. Update setting User is encouraged to adpot predefined variable to customize owner mail template. See right side for explanation of predined variables. Html code supported. User name displayed after @ Your comment on [%blog_name%] just been replied by %comment_author% Your comment, last comment of @user in post in case of '[Reply]' (exclude ') inputted. Project-Id-Version: Mailtocomment
POT-Creation-Date: 
PO-Revision-Date: 2008-10-05 00:12+0900
Last-Translator: ThinkAgain <lovepcblog@gmail.com>
Language-Team: 
MIME-Version: 1.0
Content-Type: text/plain; charset=utf-8
Content-Transfer-Encoding: 8bit
X-Poedit-KeywordsList: _e;__
X-Poedit-Basepath: .
X-Poedit-SearchPath-0: .
 '@+user+:' '@+user+blank' 1. Content in the form beneath is the output of function mailtocommenter_description(). Checked will diplay the following description under comment form. 2. You also can specify the position of description. To do this, please keep option unchecked and place <span style="background-color:#EDEDFF">&lt;?php if(function_exists('mailtocommenter_description')) mailtocommenter_description();?&gt;</span> into theme file. <b>Advice:</b> Simply click Preview button to see the mail content style while editing. <b>Button display</b>: <b>Button title display</b>, content which displayed when user hovers mouse over button: <b>Content generated by click button</b> <b>Note:</b> Commenter is allowed to use <b>'@User+blank'</b> to automatically notify your reply to other commenter. e.g, if ABC is one of commenter of this post, then write '@ABC '(exclude ') will automatically send your comment to ABC. Using '@all ' to notify all previous commenters. Be sure that the value of User should exactly match with commenter's name (case sensitive). <b>Note:</b><br/>1. Again, be sure the value of %rss_link% is correctly placed. <b>Note</b>: User can use this section to test whether your wordpress works well with mail sending or not. <br/>2. If your <b>mail service doesn't provide html format message</b>, please remove all html tag in template. @Reply style. i.e, @<a href="#">User </a>. Activate '@all ' or '@all:'. Activate mail notification. Address: Admin Admin email Anyone Blog link Blog name Checked will allow Wordpress to automatically send mail if comment content contains following specified code. Checked will allow user to use @all or @all: to send comment to all previous commenter. This option may make mail inundant to commenter. Checked will copy send last mail content with the sending result indicated to admin. Be sure that activate mail notification option must be checked. Code type: Comment author, the one insert @user  Comment link Comment time Configuration updated. Content: Customize Button style: Default configuration loaded Default display. @ image in plugin folder with link. Display following description under comment form. Html code supported. Display nothing. i.e, @user will be encapsulated by html comment code &lt;!-- and --&gt;. Example: Hyperlink. Link targets to the comment you want to reply. e.g, <a href="#">@User </a>. Keep configurations of Mail To Commenter while plugin deactivation. Language setting updated. Waiting for page to be reloaded... Load default Mail Content: Mail Subject: Mail Template Hello, %user%.<br/>Your comment on 《<a href='%post_link%'>%post_title%</a>》just been replied by（%comment_author%）. Why not check it rightnow. ^_^<br/><div style="padding:5px;border:1px solid #888;">Your comment:<br />%your_comment%<div style="margin-left:5px;margin-right:5px;padding:5px;border:1px solid #ccc;">   New reply:<br />%reply_comment%<br /><div align='right'>%comment_time%</div></div></div><div style="margin-top:10px;padding-bottom:10px;border-bottom:1px solid #ccc;"><a href="%comment_link%" target="_blank">View reply</a>, or click <a href="mailto:%admin_email%">here</a> to send mail to Admin</div><div align='right'>DO Not reply this mail</div><a href="%blog_link%">%blog_name%</a>，Welcom to subscribe to <a href="%rss_link%">%rss_name%</a>.<br/>Mail notification service is provided by <a href="http://wordpress.org/extend/plugins/mailtocommenter/">Mail To Commenter</a>. Mail sent. Meaning of predefined variables Notify Admin. Notify this pumpkin. Permission for using @all or @all: Permission to use mail notification: Place <span style="background-color:#EDEDFF">&lt;?php if(function_exists('mailtocommenter_button')) mailtocommenter_button();?&gt;</span> into theme file to display button. Plain text. e.g, @user . Post link Post title Preview RSS link display, default is RSS RSS link, please specify your rss link since most people use third party (feedburner/feedsky) to manage rss. Reply Reply comment, comment of the one who insert @user Select Language:  Send Send Mail Specify the output of function mailtocommenter_button(). Html code supported. Default is to use notify.png image file in plugin folder, you can specify other image file or use plain text, like [reply]: Subject:  This section configures the style of button generated by function mailtocommenter_button(). Unchecked will automatically remove all associated settings from database. Update setting User is encouraged to adpot predefined variable to customize owner mail template. See right side for explanation of predined variables. Html code supported. User name displayed after @ Your comment on [%blog_name%] just been replied by %comment_author% Your comment, last comment of @user in post in case of '[Reply]' (exclude ') inputted. 