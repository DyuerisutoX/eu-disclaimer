<?php

    //S'assure que le formulaire ne soit pas vide lorsque l'on envoie les données
    if(!empty($_POST['message_disclaimer']) && !empty($_POST['url_redirection']))
    {
        $text = new DisclaimerOptions();
        $text->setMessageDisclaimer(htmlspecialchars($_POST['message_disclaimer']));
        $text->setRedirectionko(htmlspecialchars($_POST['url_redirection']));
        $message = DisclaimerGestionTable::insererDansTable($text);
    }

?>

<!-- Contenu du menu du plugin eu-disclaimer -->

<h1>EU DISCLAIMER</h1>
<br>

<h2>Configuration</h2>

<p><?php if(isset($message)) echo $message; ?></p>
<form method="post" action="" novalidate="novalidate">
    <table class="form-table">
        <tr>
            <th scope="row"><label for="blogname">Message du disclaimer</label></th>

            <td>
                <input name="message_disclaimer" type="text" id="message_disclaimer" value="Au regard de la loi européenne, vous devez nous confirmer que vous avez plus de 18 ans pour visiter ce site ?" class="regular-text" />
            </td>

        </tr>

        <tr>
            <th scope="row"><label for="blogname">Url de redirection</label></th>

            <td>
                <input name="url_redirection" type="text" id="url_redirection" value="https://www.google.com" class="regular-text" />
            </td>

        </tr>
    </table>

    <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Enregistrer les modifications"/></p>
</form>

<br>

<p>Exemple: La législation nous impose de vous informer sur la nocivité des produits à base de nicotine, vous devez avoir plus de 18 ans pour consulter ce site !</p>
<br>

<h3>Centre AFPA / session DWWM</h3>

<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) .'assets/img/layout_set_logo.png'; ?>" width="10%">

<p>Comment afficher le plugin ?</p>
<p>Afficher ce code php sous la balise body html: </p>
<p>if( shortcode_exists('eu-disclaimer')){ echo do_shortcode('[eu-disclaimer]');}</p>