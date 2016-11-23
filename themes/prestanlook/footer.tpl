{*
* 2007-2016 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
{if !isset($content_only) || !$content_only}
					</div><!-- #center_column -->
					{if isset($right_column_size) && !empty($right_column_size)}
						<div id="right_column" class="col-xs-12 col-sm-{$right_column_size|intval} column">{$HOOK_RIGHT_COLUMN}</div>
					{/if}
					</div><!-- .row -->
				</div><!-- #columns -->
			</div><!-- .columns-container -->
			{if isset($HOOK_FOOTER)}
				<!-- Footer -->
                                <div id="footer-first" class="container">
                                    <div class="col-xs-4">
                                        <div class="ffirst-one">zadzwoń</div>
                                        <div class="ffirst-second">Biuro Obsługi Klienta</div>
                                        <div class="ffirst-third">
                                            <div class="icon-phone"></div>
                                            <div class="item-first">
                                                <div class="bold">+48 502 554 557</div>
                                                <div>(od pon. do pt. w godz. 08:00 - 16:00)</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="ffirst-one">Godziny otwarciań</div>
                                        <div class="ffirst-second">Jesteśmy do dyspozycji</div>
                                        <div class="ffirst-third">Poniedziałek-Piątek <span class="right"> 07:00 - 17:00 </span></br> Sobota<span class="right" > 07:00 - 13:30</span></div>
                                    </div>
                                    <div class="col-xs-4" id="last">
                                        <div id="footer-nolady">
                                            <div class="ffirst-one">SKONTAKTUJ SIĘ</div>
                                            <div class="ffirst-second">Napisz do nas!</div>
                                            <div class="ffirst-third">Odpowiadamy w ciągu </br>24 godzin</div>
                                            </div>
                                        <div id="footer-lady">
                                            <img  src="http://139.59.138.126/prestan/img/footer-lady.png"  width="121" height="193">
                                        </div>
                                    </div>
                                    
                                </div>
                                <div id="footer-black-row">
                                    <div class="black-row-text">Skonfiguruj swój komputer</div>
                                    <div class="black-row-button">już teraz</div>
                                </div>
                                <div class="container delivery">
                                    <div id="footer-man">
                                        <img src="http://139.59.138.126/prestan/img/footer-man.png" width="285" height="267">
                                    </div>
                                    <div class="col-xs-6 fm fm-first">
                                        <div class="fm-item-first">Darmowa dostawa</div>
                                        <div class="fm-item-second">już od 500 zł *</div>
                                        <div class="fm-item-third">sprawdź teraz</div>
                                    </div>
                                    <div class="col-xs-6 fm">
                                        <div class="fm-item-first">Darmowa dostawa</div>
                                        <div class="fm-item-second">już od 500 zł *</div>
                                        <div class="fm-item-third">sprawdź teraz</div>
                                    </div>
                                   </div>
                                <div class="container" >
                                     <div id="fm-line"> </div>
                                </div>
				<div class="footer-container">
					<footer id="footer"  class="container">
						<div class="row">{$HOOK_FOOTER}</div>
					</footer>
				</div><!-- #footer -->
                                
                                koniec footera
			{/if}
		</div><!-- #page -->
{/if}
{include file="$tpl_dir./global.tpl"}
	</body>
</html>