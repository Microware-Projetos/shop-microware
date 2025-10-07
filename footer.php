</div>
</div>

<style>
.footer-section {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    color: #ffffff;
    box-shadow: 0 -4px 20px rgba(0,0,0,0.3);
    /* border-top: 3px solid #007bff; */
}

.footer-content {
    padding: 40px 0;
}

.footer-row {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: stretch;
    gap: 30px;
}

.footer-column {
    flex: 1;
    min-width: 260px;
    max-width: 340px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.footer-column .footer-title,
.footer-column h4 {
    text-align: left;
}

.footer-logo {
    margin-bottom: 20px;
}

.footer-logo img {
    max-height: 60px;
    width: auto;
}

.footer-links ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    margin-bottom: 8px;
    display: flex;
    align-items: center;
}

.footer-links a {
    color: #ffffff;
    text-decoration: none;
    transition: color 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.footer-links a:hover {
    color: #007bff;
}

.footer-links .icon {
    font-size: 12px;
    color: #ffffff;
}

.contact-area, .footer-social {
    width: 100%;
    justify-content: flex-start;
}

.contact-area {
    margin-bottom: 20px;
    padding: 0 0 0 2px;
}

.footer-social {
    justify-content: flex-start;
    margin-top: 24px;
}

.contact-icon {
    flex-shrink: 0;
    width: 48px;
    height: 48px;
    background: rgba(255,255,255,0.07);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: none;
    transition: background 0.3s;
}

.contact-icon i {
    color: #fff !important;
    font-size: 18px;
    transition: color 0.3s;
}

.contact-area:hover .contact-icon {
    background: #007bff;
}

.contact-area:hover .contact-icon i {
    color: #fff;
}

.contact-info p, .contact-info a {
    margin: 0 0 5px 0;
    color: #e0e0e0;
    font-size: 16px;
    text-align: left;
    letter-spacing: 0.2px;
    font-weight: 400;
}

.contact-info a {
    color: #e0e0e0;
    text-decoration: none;
    transition: color 0.3s;
}

.contact-info a:hover {
    color: #007bff;
}

.services-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.services-list li {
    margin-bottom: 8px;
    padding: 8px 12px;
    background: rgba(255,255,255,0.05);
    border-radius: 6px;
    transition: all 0.3s ease;
}

.services-list li:hover {
    background: rgba(0,123,255,0.1);
    transform: translateX(5px);
}

.services-list a {
    color: #e0e0e0;
    text-decoration: none;
    font-size: 14px;
    display: block;
}

.services-list a:hover {
    color: #007bff;
}

@media (max-width: 900px) {
    .footer-row {
        flex-direction: column;
        align-items: stretch;
    }
    .footer-column {
        max-width: 100%;
        min-width: 0;
    }
}

/* Redes sociais no footer */
.footer-social {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-top: 18px;
}

.social-row {
    display: flex;
    justify-content: flex-start;
    gap: 18px;
}
.footer-social a {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    background: rgba(255,255,255,0.12);
    border-radius: 10px;
    transition: all 0.3s ease;
    text-decoration: none;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}
.footer-social a:hover {
    background: #007bff;
}
.footer-social i {
    color: #fff;
    font-size: 22px;
    transition: color 0.3s;
}

/* Estilos para ícones PNG */
.footer-social .social-icon {
    width: 28px;
    height: 28px;
    filter: brightness(0) invert(1); /* Torna os ícones brancos */
    transition: all 0.3s ease;
}

.footer-social a:hover .social-icon {
    filter: brightness(0) invert(1); /* Mantém branco no hover */
    transform: scale(1.1); /* Aumenta um pouco no hover */
}
</style>

<footer id="footer-section" class="footer-section main-footer">
    <div class="footer-content">
        <div class="container">
            <div class="footer-row">
                <!-- Coluna 1: Logo, Links e Redes Sociais -->
                <div class="footer-column">
                    <div class="footer-logo">
                        <a href="javascript:void(0);">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="Microware">
                        </a>
                    </div>
                    <div class="footer-links">
                        <ul>
                            <li>
                                <a href="https://www.microware.com.br/quem-somos" target="_blank" title="Quem Somos">
                                    <i class="fa fa-users icon"></i>
                                    Quem Somos
                                </a>
                            </li>
                            <li>
                                <a href="https://www.microware.com.br/contato" target="_blank" title="Contato">
                                    <i class="fa fa-envelope icon"></i>
                                    Contato
                                </a>
                            </li>
                            <li>
                                <a href="https://www.microware.com.br/comunicados" target="_blank" title="Comunicados">
                                    <i class="fa fa-bullhorn icon"></i>
                                    Comunicados
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="footer-social">
                        <!-- Primeira linha: 3 ícones -->
                        <div class="social-row">
                            <a href="https://www.linkedin.com/company/microwarebr/" target="_blank" title="LinkedIn" rel="noopener">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/icons8-linkedin-50.png" alt="LinkedIn" class="social-icon">
                            </a>
                            <a href="https://www.instagram.com/microwarebr/" target="_blank" title="Instagram" rel="noopener">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/icons8-instagram-50.png" alt="Instagram" class="social-icon">
                            </a>
                            <a href="https://www.youtube.com/@microwarebr/shorts" target="_blank" title="YouTube" rel="noopener">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/icons8-youtube-50.png" alt="YouTube" class="social-icon">
                            </a>
                        </div>
                        <!-- Segunda linha: 3 ícones -->
                        <div class="social-row">
                            <a href="https://www.tiktok.com/@microwarebr/" target="_blank" title="TikTok" rel="noopener">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/icons8-tiktok-50.png" alt="TikTok" class="social-icon">
                            </a>
                            <a href="https://wa.me/551148722100?text=Ol%C3%A1%2C%20Microware!" target="_blank" title="WhatsApp" rel="noopener">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/icons8-whatsapp-50.png" alt="WhatsApp" class="social-icon">
                            </a>
                            <a href="https://dj-gy304.eu1.hubspotlinks.com/Ctc/JA+113/dj-gy304/VWfBvy1_YK-nW8YNJSM7zwx9bV7Wb0N5sy5v7N2jjSxY3qn9gW8wLKSR6lZ3q4V82d0X8lX2t3W7JWf226jNl74W3zlvcs7TkR27N8D-c9DQvNXNV6qQKc7_x_pjW8y-XY_3tSLGPW7VRC-w801YbMW4lKm-C6Y97MHW3Mqfcx1fSS0_W5YD_gz5PVzzNF1Mwxc9Z6dvW71ss-N4H-jKZW7sz81n6s3Pn5W8Djb2t3MWKM0N8Rns0rfNb99W7_8TfC7FzKgYW8DRT4Y3hn71kW8Kq5Gv7Sh07PW904Pn18049zFW2WHGMq2KBHLDW91vmzY23TC1TW6KL0G-6NX9hgW2WSzF58N90-VV4HXMr3mVvnXV5vmHY1LqHwqW2ShzXx3XbzQnN3-lhb0blkx2W5263H41rgwZ9f7qks4W04" target="_blank" title="Microsoft Teams" rel="noopener">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/icons8-teams-50.png" alt="Microsoft Teams" class="social-icon">
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Coluna 2: Contatos -->
                <div class="footer-column">
                    <h4 style="color: #ffffff; margin-bottom: 15px; font-size: 16px; font-weight: bold;">Fale Conosco</h4>
                    <div class="footer-links">
                        <ul>
                            <li>
                                <a href="tel:1148722100" title="SP (11) 4872-2100">
                                    <i class="fa fa-phone icon"></i>
                                    SP (11) 4872-2100
                                </a>
                            </li>
                            <li>
                                <a href="tel:2121992600" title="RJ (21) 2199-2600">
                                    <i class="fa fa-phone icon"></i>
                                    RJ (21) 2199-2600
                                </a>
                            </li>
                            <li>
                                <a href="tel:6135336737" title="DF (61) 3533-6737">
                                    <i class="fa fa-phone icon"></i>
                                    DF (61) 3533-6737
                                </a>
                            </li>
                            <li>
                                <a href="tel:2734001170" title="ES (27) 3400-1170">
                                    <i class="fa fa-phone icon"></i>
                                    ES (27) 3400-1170
                                </a>
                            </li>
                            <li>
                                <a href="mailto:microware@microware.com.br" title="Email">
                                    <i class="fa fa-envelope icon"></i>
                                    microware@microware.com.br
                                </a>
                            </li>
                            <li>
                                <span style="color: #e0e0e0;">
                                    <i class="fa fa-building icon"></i>
                                    SP 01.724.795/0001-43
                                </span>
                            </li>
                            <li>
                                <span style="color: #e0e0e0;">
                                    <i class="fa fa-building icon"></i>
                                    ES 01.724.795/0007-39
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Coluna 3: Serviços -->
                <div class="footer-column">
                    <h4 style="color: #ffffff; margin-bottom: 15px; font-size: 16px;">Nossos Serviços</h4>
                    <ul class="services-list">
                        <li>
                            <a href="https://www.microware.com.br/transformacao-digital" target="_blank" rel="noopener">
                                Transformação Digital
                            </a>
                        </li>
                        <li>
                            <a href="https://www.microware.com.br/nuvem" target="_blank" rel="noopener">
                                Nuvem, Datacenter e Conectividade
                            </a>
                        </li>
                        <li>
                            <a href="https://www.microware.com.br/borda-inteligente" target="_blank" rel="noopener">
                                Borda Inteligente
                            </a>
                        </li>
                        <li>
                            <a href="https://www.microware.com.br/seguranca" target="_blank" rel="noopener">
                                Segurança
                            </a>
                        </li>
                        <li>
                            <a href="https://www.microware.com.br/fornecimento-estrategico" target="_blank" rel="noopener">
                                Fornecimento Estratégico e Global
                            </a>
                        </li>
                        <li>
                            <a href="https://www.microware.com.br/marketing-digital" target="_blank" rel="noopener">
                                Marketing Digital
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

<button type="button" class="scrollingUp scrolling-btn" aria-label="scrollingUp"><i class="fa fa-angle-up"></i></button>

<?php wp_footer(); ?>
</body>
</html>