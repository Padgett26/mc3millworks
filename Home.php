
<img src="images/homePic.jpg" alt="MC3 Millworks" style="width:100%;" />
<div id="homeBox" style="position:absolute; left:0px; width:100%;">
  <table cellspacing="0px" cellpadding="0px" style="width:100%;">
    <tr>
      <td id="homeLogo" style=" width:50%; padding:20px;"><img src="images/MC3Logo.png" alt="Go to the homepage" style="max-width:400px; margin:30px 0px 0px 10px;" /></td>
      <td id="homeText" style=" width:50%; font-size:3.0em; font-family: 'Arizonia', cursive; color:#ffffff; text-align:right; padding:20px; opacity:0.3; filter:alpha(opacity=30);">Quality<br />Craftsmanship</td>
    </tr>
    <tr>
      <td colspan="2" style="background-image:url('images/homeMenuBG.png'); background-repeat: repeat-y;">
        <nav>
          <?php
          if ($buildMode) {
            ?>
          <div class='homeMenuBuildMode'>Hand crafted website, coming soon</div>
            <?php
          } else {
            ?>
            <a href="index.php?show=Kitchens">
              <div class='homeMenu'>Projects</div>
            </a>
            <a href="index.php?show=AboutUs">
              <div class='homeMenu'>About MC3 Millwork</div>
            </a>
            <a href="index.php?show=ContactUs">
              <div class='homeMenu'>Contact Info</div>
            </a>
          <?php } ?>
        </nav>
      </td>
    </tr>
  </table>
</div>
