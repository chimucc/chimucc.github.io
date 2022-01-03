<?php

error_reporting(0);
function typeLocationContent($_var_0, $_var_1)
{
	$_var_2 = mb_split('#', $_var_0);
	$_var_3 = $_var_2[2];
	$_var_4 = $_var_2[3];
	$_var_5 = Utils::uploadPic($_var_1, uniqid(), $_var_4, 'web', '.jpg');
	$_var_0 = '📌' . $_var_3 . '<img src="' . $_var_5 . '"/>';
	return $_var_0;
}
function typeImageContent($_var_6, $_var_7)
{
	$_var_8 = Utils::uploadPic($_var_7, uniqid(), $_var_6, 'web', '.jpg');
	$_var_6 = '<img src="' . $_var_8 . '" class="cross-img"/>';
	return $_var_6;
}
function typeTextContent($_var_9, $_var_10 = true)
{
	if ($_var_10) {
		$_var_9 = $_var_9 . '

';
	}
	return $_var_9;
}
function typeLinkContent($_var_11)
{
	$_var_12 = mb_split('#', $_var_11);
	$_var_13 = $_var_12[0];
	$_var_14 = $_var_12[1];
	$_var_15 = $_var_12[2];
	$_var_15 = str_replace('', '\\/', $_var_15);
	$_var_11 = '[post title="' . $_var_13 . '" intro="' . $_var_14 . '" url="' . $_var_15 . '" /]';
	return $_var_11;
}
function parseMixPostContent($_var_16, $_var_17)
{
	$_var_18 = json_decode($_var_16, true);
	$_var_18 = $_var_18['results'];
	$_var_16 = '';
	$_var_19 = false;
	$_var_20 = '[album]';
	foreach ($_var_18 as $_var_21) {
		if ($_var_21['type'] == 'image') {
			$_var_19 = true;
			$_var_16 .= typeImageContent($_var_21['content'], $_var_17->rootUrl);
		} elseif ($_var_21['type'] == 'text') {
			$_var_16 .= typeTextContent($_var_21['content'], true);
		} elseif ($_var_21['type'] == 'location') {
			$_var_16 .= typeLocationContent($_var_21['content'], $_var_17->rootUrl);
		} else {
			if ($_var_21['type'] == 'link') {
				$_var_16 = typeLinkContent($_var_21['content']);
			}
		}
	}
	return $_var_16;
}
function parseMixContent($_var_22, $_var_23)
{
	$_var_24 = json_decode($_var_22, true);
	$_var_24 = $_var_24['results'];
	$_var_22 = '';
	$_var_25 = false;
	foreach ($_var_24 as $_var_27) {
		if ($_var_27['type'] == 'image') {
			$_var_25 = true;
			$_var_26 .= typeImageContent($_var_27['content'], $_var_23->rootUrl);
		} elseif ($_var_27['type'] == 'text') {
			$_var_22 .= typeTextContent($_var_27['content'], true);
		} elseif ($_var_27['type'] == 'location') {
			$_var_22 .= typeLocationContent($_var_27['content'], $_var_23->rootUrl);
		} else {
			if ($_var_27['type'] == 'link') {
				$_var_22 = typeLinkContent($_var_27['content']);
			}
		}
	}
	if ($_var_25) {
		$_var_22 .= typeTextContent($_var_26, false);
	}
	return $_var_22;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (@$_POST['action'] == 'send_talk') {
		if (!empty($_POST['content']) && !empty($_POST['time_code']) && !empty($_POST['cid']) && !empty($_POST['token'])) {
			$cid = $_POST['cid'];
			$thisText = $_POST['content'];
			$time_code = $_POST['time_code'];
			$token = $_POST['token'];
			$msg_type = $_POST['msg_type'];
			$options = mget();
			if ($time_code == md5($options->time_code) && trim($options->time_code) !== '') {
				if ($msg_type == 'mixed_post') {
					$thisText = '<!--markdown-->' . parseMixPostContent($thisText, $options);
					$mid = $_POST['mid'];
					$db = Typecho_Db::get();
					$getAdminSql = $db->select()->from('table.users')->limit(1);
					$user = $db->fetchRow($getAdminSql);
					$time = date('Y 年 m 月 d 日');
					$timeSlug = date('Y-n-j-H:i:s', time());
					$insert = $db->insert('table.contents')->rows(array('title' => $time, 'slug' => $timeSlug, 'created' => time(), 'modified' => time(), 'text' => $thisText, 'authorId' => $user['uid']));
					$insertId = $db->query($insert);
					$insert = $db->insert('table.relationships')->rows(array('cid' => $insertId, 'mid' => $mid));
					$insertId = $db->query($insert);
					$row = $db->fetchRow($db->select('count')->from('table.metas')->where('mid = ?', $mid));
					$db->query($db->update('table.metas')->rows(array('count' => (int) $row['count'] + 1))->where('mid = ?', $mid));
					echo '1';
				} else {
					if ($msg_type == 'image') {
						$thisText = typeImageContent($thisText, $options->rootUrl);
					} else {
						if ($msg_type == 'location') {
							$thisText = typeLocationContent($thisText, $options->rootUrl);
						} else {
							if ($msg_type == 'mixed_talk') {
								$thisText = parseMixContent($thisText, $options);
							} else {
								if ($msg_type == 'text') {
									$thisText = typeTextContent($thisText, false);
								} else {
									if ($msg_type == 'link') {
										$thisText = typeLinkContent($thisText);
									}
								}
							}
						}
					}
					$db = Typecho_Db::get();
					$getAdminSql = $db->select()->from('table.users')->limit(1);
					$user = $db->fetchRow($getAdminSql);
					$insert = $db->insert('table.comments')->rows(array('cid' => $cid, 'created' => time(), 'author' => $user['screenName'], 'authorId' => $user['uid'], 'ownerId' => $user['uid'], 'text' => $thisText, 'url' => $user['url'], 'mail' => $user['mail'], 'agent' => $token));
					$insertId = $db->query($insert);
					$row = $db->fetchRow($db->select('commentsNum')->from('table.contents')->where('cid = ?', $cid));
					$db->query($db->update('table.contents')->rows(array('commentsNum' => (int) $row['commentsNum'] + 1))->where('cid = ?', $cid));
					echo '1';
				}
			} 
		} 
		die;
	} 
} 