<?php
/**
 * Created by PhpStorm.
 * User: s.atapin
 * Date: 27.02.2018
 * Time: 11:54
 */
\Bitrix\Main\Loader::registerAutoLoadClasses(
    "threeweb.telegramchat",
 array(
    '\Threeweb\Telegramchat\ChatTable'=>'/lib/chat.php',
     '\Threeweb\Telegramchat\ChatListTable'=>'/lib/chat_list.php',
     '\Threeweb\Telegramchat\BotTable'=>'/lib/bot.php',
     '\Threeweb\Telegramchat\ManagerTable'=>'/lib/manager.php',
     '\Threeweb\Telegramchat\MessageTable'=>'/lib/message.php',
	 
	 'telegramChat'=>'classes/mysql/chat.php',
	 'telegramBot'=>'classes/mysql/bot.php',
	 'telegramManager'=>'classes/mysql/manager.php',
	 'telegramMsg'=>'classes/mysql/message.php',
	 'telegramChatList'=>'classes/mysql/chat_list.php',
	 
 )
 );
 
