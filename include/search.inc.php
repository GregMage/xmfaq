<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * xmfaq module
 *
 * @copyright       XOOPS Project (http://xoops.org)
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author          Mage Gregory (AKA Mage)
 */

function xmfaq_search($queryarray, $andor, $limit, $offset, $userid)
{
    global $xoopsDB;

    $sql = "SELECT question_id, question_cid, question_title, question_answer, question_weight, question_status FROM ".$xoopsDB->prefix("xmfaq_question")." WHERE question_status != 0";

    if ( is_array($queryarray) && $count = count($queryarray) )
    {
        $sql .= " AND ((question_title LIKE '%$queryarray[0]%' OR question_answer LIKE '%$queryarray[0]%')";

        for($i=1;$i<$count;$i++)
        {
            $sql .= " $andor ";
            $sql .= "(question_title LIKE '%$queryarray[$i]%' OR question_answer LIKE '%$queryarray[$i]%')";
        }
        $sql .= ")";
    }

    $sql .= " ORDER BY question_weight DESC";
    $result = $xoopsDB->query($sql,$limit,$offset);
    $ret = array();
    $i = 0;
    while($myrow = $xoopsDB->fetchArray($result))
    {
        $ret[$i]["image"] = "images/xmfaq_search.png";
        $ret[$i]["link"] = "viewcategory.php?category_id=" . $myrow["question_cid"];
        $ret[$i]["title"] = $myrow["question_title"];
        $i++;
    }

    return $ret;
}