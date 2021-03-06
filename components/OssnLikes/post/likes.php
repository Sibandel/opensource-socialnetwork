<?php
/**
 * Open Source Social Network
 *
 * @package   Open Source Social Network
 * @author    Open Social Website Core Team <info@informatikon.com>
 * @copyright 2014 iNFORMATIKON TECHNOLOGIES
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      http://www.opensource-socialnetwork.org/licence
 */

$OssnLikes = new OssnLikes;
$OssnComments = new OssnComments;

$object = $params->guid;
$count = $OssnLikes->CountLikes($object);

$user_liked = '';
?>
<?php if (ossn_isLoggedIn()) { ?>

    <div class="like_share comments-like-comment-links">
        <div id="ossn-like-<?php echo $object; ?>" class="button-container">
            <?php
            if (!$OssnLikes->isLiked($object, ossn_loggedin_user()->guid)) {
                $link['onclick'] = "Ossn.PostLike({$object});";
                $link['href'] = 'javascript::;';
                $link['text'] = ossn_print('ossn:like');
                echo ossn_view('system/templates/output/url', $link);

            } else {
                $user_liked = true;
                $link['onclick'] = "Ossn.PostUnlike({$object});";
                $link['href'] = 'javascript::;';
                $link['text'] = ossn_print('ossn:unlike');
                echo ossn_view('system/templates/output/url', $link);
            }
            ?>
        </div>
        <span class="dot-comments">.</span>
        <a href="#comment-box-<?php echo $object; ?>"><?php echo ossn_print('comment:comment'); ?></a>
        <?php if ($OssnComments->countComments($object) > 5) { ?>
            <span class="dot-comments">.</span> <a href="<?php echo ossn_site_url("post/view/{$object}"); ?>"><?php echo ossn_print('comment:view:all'); ?></a>
        <?php } ?>
    </div>

<?php } /* Likes and comments don't show for nonlogged in users */ ?>

<?php if ($OssnLikes->CountLikes($object)) { ?>
    <div class="like_share">
        <div class="ossn-like-icon"></div>
        <?php if ($user_liked == true && $count == 1) { ?>
            <?php echo ossn_print("ossn:liked:you"); ?>
        <?php
        } elseif ($user_liked == true && $count > 1) {
            $count = $count - 1;
            $total = 'person';
            if ($count > 1) {
                $total = 'people';
            }
            $link['onclick'] = "Ossn.ViewLikes({$object});";
            $link['href'] = '#';
            $link['text'] = ossn_print("ossn:like:{$total}", array($count));
            $link = ossn_view('system/templates/output/url', $link);
            echo ossn_print("ossn:like:you:and:this", array($link));
        } elseif (!$user_liked) {
            $total = 'person';
            if ($count > 1) {
                $total = 'people';
            }
            $link['onclick'] = "Ossn.ViewLikes({$object});";
            $link['href'] = '#';
            $link['text'] = ossn_print("ossn:like:{$total}", array($count));
            $link = ossn_view('system/templates/output/url', $link);
            echo ossn_print("ossn:like:this", array($link));
        }?>
    </div>
<?php } ?>
