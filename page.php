<div id="pageBanner" style="margin-top:5px; position:relative; top:0px; left:0px; overflow:hidden;">
    <img src="images/homePic.jpg" alt="MC3 Millworks" style="width:1000px; height:250px; position:absolute; top:0px;" />
    <div style="position:absolute; bottom:0px; left:0px; width:100%;">
        <table cellspacing="0px" cellpadding="0px" style="width:100%;">
            <tr>
                <td id="homeLogo" style=" width:50%; padding:20px;"><a href="index.php?show=Home"><img src="images/MC3Logo.png" alt="Go to the homepage" style="max-width:370px; margin:40px 0px 0px 10px;" /></a></td>
                <td id="homeText" style=" width:50%; font-size:3.0em; font-family: 'Arizonia', cursive; color:#ffffff; text-align:right; padding:20px; opacity:0.3; filter:alpha(opacity=30);">Quality<br />Craftsmanship</td>
            </tr>
        </table>
    </div>
</div>

<div style="width:100%; position:relative; top:0px; left:0px;">
  <div style="width:100%; position:relative; top:0px; left:0px;">
    <?php
    include "includes/Menu.php";
    ?>
  </div>
    <article id="pageArticle" style="display:inline-block; height:100%; width:100%; padding:0px; background-color:#ffffff; color:#000000; position:relative; top: 0px; left:30px; border:1px solid black; vertical-align:top;">
        <div id="showPage">
            <?php
            include "includes/pageData.php";
            ?>
        </div>
    </article>
</div>
<script src="js/lightbox-plus-jquery.min.js"></script>