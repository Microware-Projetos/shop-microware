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
    gap: 18px;
    margin-top: 18px;
}
.footer-social a {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    background: rgba(255,255,255,0.10);
    border-radius: 8px;
    transition: background 0.3s;
    text-decoration: none;
}
.footer-social a:hover {
    background: #007bff;
}
.footer-social i {
    color: #fff;
    font-size: 22px;
    transition: color 0.3s;
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
                            <img src="https://www.microware.com.br/uploads/2/7/2/6/27264807/editor/logo-microware-borda-branca_3.png" alt="Microware">
                        </a>
                    </div>
                    <div class="footer-links">
                        <ul>
                            <li>
                                <a href="https://www.microware.com.br/quem-somos.html" target="_blank" title="Quem Somos">
                                    <i class="fa fa-users icon"></i>
                                    Quem Somos
                                </a>
                            </li>
                            <li>
                                <a href="https://www.microware.com.br/contato.html" target="_blank" title="Contato">
                                    <i class="fa fa-envelope icon"></i>
                                    Contato
                                </a>
                            </li>
                            <li>
                                <a href="https://www.microware.com.br/comunicados.html" target="_blank" title="Comunicados">
                                    <i class="fa fa-bullhorn icon"></i>
                                    Comunicados
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="footer-social">
                        <a href="https://www.linkedin.com/company/microwarebr/" target="_blank" title="LinkedIn" rel="noopener"><i class="fa fa-linkedin"></i></a>
                        <a href="https://www.instagram.com/microwarebr/" target="_blank" title="Instagram" rel="noopener"><i class="fa fa-instagram"></i></a>
                        <a href="https://www.youtube.com/@microwarebr/shorts" target="_blank" title="YouTube" rel="noopener"><i class="fa fa-youtube-play"></i></a>
                        <a href="https://www.tiktok.com/@microwarebr/" target="_blank" title="TikTok" rel="noopener">
                            <svg fill="#ffffff" width="22px" height="22px" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                <path d="M412.19,118.66a109.27,109.27,0,0,1-9.45-5.5,132.87,132.87,0,0,1-24.27-20.62c-18.1-20.71-24.86-41.72-27.35-56.43h.1C349.14,23.9,350,16,350.13,16H267.69V334.78c0,4.28,0,8.51-.18,12.69,0,.52-.05,1-.08,1.56,0,.23,0,.47-.05.71,0,.06,0,.12,0,.18a70,70,0,0,1-35.22,55.56,68.8,68.8,0,0,1-34.11,9c-38.41,0-69.54-31.32-69.54-70s31.13-70,69.54-70a68.9,68.9,0,0,1,21.41,3.39l.1-83.94a153.14,153.14,0,0,0-118,34.52,161.79,161.79,0,0,0-35.3,43.53c-3.48,6-16.61,30.11-18.2,69.24-1,22.21,5.67,45.22,8.85,54.73v.2c2,5.6,9.75,24.71,22.38,40.82A167.53,167.53,0,0,0,115,470.66v-.2l.2.2C155.11,497.78,199.36,496,199.36,496c7.66-.31,33.32,0,62.46-13.81,32.32-15.31,50.72-38.12,50.72-38.12a158.46,158.46,0,0,0,27.64-45.93c7.46-19.61,9.95-43.13,9.95-52.53V176.49c1,.6,14.32,9.41,14.32,9.41s19.19,12.3,49.13,20.31c21.48,5.7,50.42,6.9,50.42,6.9V131.27C453.86,132.37,433.27,129.17,412.19,118.66Z"/>
                            </svg>
                        </a>
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
                            <a href="https://www.microware.com.br/transformacao-digital.html" target="_blank" rel="noopener">
                                Transformação Digital
                            </a>
                        </li>
                        <li>
                            <a href="https://www.microware.com.br/nuvem-datacenter-hibrido-conectividade.html" target="_blank" rel="noopener">
                                Nuvem, Datacenter e Conectividade
                            </a>
                        </li>
                        <li>
                            <a href="https://www.microware.com.br/borda-inteligente.html" target="_blank" rel="noopener">
                                Borda Inteligente
                            </a>
                        </li>
                        <li>
                            <a href="https://www.microware.com.br/seguranca.html" target="_blank" rel="noopener">
                                Segurança
                            </a>
                        </li>
                        <li>
                            <a href="https://www.microware.com.br/fornecimento-estrategico-global.html" target="_blank" rel="noopener">
                                Fornecimento Estratégico e Global
                            </a>
                        </li>
                        <li>
                            <a href="https://www.microware.com.br/marketing-digital.html" target="_blank" rel="noopener">
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
