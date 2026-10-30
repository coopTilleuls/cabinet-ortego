<?php
/**
 * Consent banner for the two external services (Calendly, map). Hidden until consent.js runs:
 * without JavaScript nothing external can load, so there is nothing to consent to.
 * Not modal, placed in the flow at the bottom of the page; "Accepter" and "Refuser" share the same style.
 */

declare(strict_types=1);
?>
<section class="consent" id="consentement" aria-labelledby="consentement-titre" tabindex="-1" hidden>
    <div class="consent__inner">
        <h2 class="consent__title" id="consentement-titre"><?php esc_html_e('Cookies et contenus externes', 'tilleuls-ortego-papier'); ?></h2>
        <p>
            <?php esc_html_e('Ce site n\'utilise aucun traceur. Deux services externes (agenda Calendly, carte) déposent des cookies si vous les affichez. Vous pouvez changer d\'avis à tout moment depuis le pied de page.', 'tilleuls-ortego-papier'); ?>
        </p>
        <form class="consent__form" data-consent-form>
            <fieldset class="consent__choices" id="consentement-choix" hidden>
                <legend><?php esc_html_e('Services à autoriser', 'tilleuls-ortego-papier'); ?></legend>
                <label class="checkbox">
                    <input type="checkbox" name="calendly" value="1">
                    <span><?php esc_html_e('Agenda en ligne (Calendly)', 'tilleuls-ortego-papier'); ?></span>
                </label>
                <label class="checkbox">
                    <input type="checkbox" name="map" value="1">
                    <span><?php esc_html_e('Carte d\'accès (Google Maps)', 'tilleuls-ortego-papier'); ?></span>
                </label>
                <button type="submit" class="button button--primary" name="choice" value="custom"><?php esc_html_e('Enregistrer mes choix', 'tilleuls-ortego-papier'); ?></button>
            </fieldset>
            <div class="consent__actions">
                <button type="submit" class="button button--secondary" name="choice" value="refuse"><?php esc_html_e('Refuser', 'tilleuls-ortego-papier'); ?></button>
                <button type="submit" class="button button--secondary" name="choice" value="accept"><?php esc_html_e('Accepter', 'tilleuls-ortego-papier'); ?></button>
                <button type="button" class="button button--tertiary" aria-expanded="false" aria-controls="consentement-choix" data-consent-customize>
                    <?php esc_html_e('Personnaliser', 'tilleuls-ortego-papier'); ?>
                </button>
            </div>
            <p class="consent__status screen-reader-text" role="status" data-consent-status></p>
        </form>
    </div>
</section>
