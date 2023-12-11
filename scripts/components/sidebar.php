<?php
function sidebar($nav_dashboard, $nav_turnosP, $nav_workers, $nav_department, $nav_warnigs)
{   
    $nav = "
    <nav class='sidebar close'>
        <header>
            <div class='image-text'>
                <span class='image'>
                    <img src='../img/cuandoLibro-logo.png' alt='logoClaro' />
                </span>

                <div class='text header-text'>
                    <span class='name'>CuandoLibro</span>
                    <span class='profession'>IAW & DB</span>
                </div>
            </div>
            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class='menu-bar'>
            <div class='menu'>
                

                <ul class='menu-links'>
                    <li class='nav-links'>
                        <a href='$nav_dashboard'>
                            <i class='bx bx-home-alt-2 icon'></i>
                            <span class='text nav-text'>Dashboard</span>
                        </a>
                    </li>
                    <li class='nav-links'>
                        <a href='$nav_turnosP'>
                            <i class='bx bx-calendar-alt icon'></i>
                            <span class='text nav-text'>Horarios</span>
                        </a>
                    </li>
                    <li class='nav-links'>
                        <a href='$nav_workers'>
                            <i class='bx bx-user icon'></i>
                            <span class='text nav-text'>Trabajadores</span>
                        </a>
                    </li>
                    <li class='nav-links'>
                        <a href='$nav_department'>
                            <i class='bx bx-briefcase-alt-2 icon'></i>
                            <span class='text nav-text'>Departamentos</span>
                        </a>
                    </li>
                    <li class='nav-links'>
                        <a href='$nav_warnigs'>
                            <i class='bx bx-error icon'></i>
                            <span class='text nav-text'>Avisos</span>
                        </a>
                    </li>
                    <li class='nav-links'>
                        <a href='http://localhost/phpmyadmin/' target='_blank'>
                            <i class='bx bx-data icon'></i>
                            <span class='text nav-text'>Mysql</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class='bottom-content'>
                <li class=''>
                    <a href='../scripts/php/seguridad/cerrarSesion.php'>
                        <i class='bx bx-log-out icon'></i>
                        <span class='text nav-text'>Cerrar sesión</span>
                    </a>
                </li>
                
            </div>
        </div>
    </nav>
    
    ";

    return $nav;
}

?>