<?php
$version = time();
?>
<!DOCTYPE html>
<html lang="te">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Ethical Law</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">

    <link href="https://fonts.googleapis.com/css2?family=Mandali&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

<div id="header">

    <div id="main-header">

        <div id="title">Ethical Law</div>

        <div id="header-actions">

            <!-- Language Control -->
            <div id="language-control">

                <button id="language-btn" class="header-icon-btn" title="Language: తెలుగు">
                    <img src="../../asset/images/ethicallaw/lang-icon-black.png"
                         alt="Language"
                         class="lang-flag-img"
                         id="lang-icon">
                </button>

                <div id="language-menu" class="lang-menu">

                    <button class="lang-close-btn"
                            id="lang-close-btn"
                            title="Close">✕</button>

                    <div class="lang-options-wrapper">

                        <div class="lang-option" data-lang="telugu">
                            <input type="checkbox"
                                   class="lang-checkbox"
                                   id="lang-telugu"
                                   checked>
                            <label for="lang-telugu" class="lang-name">తె</label>
                        </div>

                        <div class="lang-option" data-lang="english">
                            <input type="checkbox"
                                   class="lang-checkbox"
                                   id="lang-english">
                            <label for="lang-english" class="lang-name">En</label>
                        </div>

                    </div>

                    <div class="lang-swap-wrapper">
                        <button id="lang-swap-btn"
                                class="lang-swap-btn"
                                title="Swap Language Order">

                            <span class="swap-arrows horizontal">
                                <i class="fa-solid fa-arrow-up"></i>
                                <i class="fa-solid fa-arrow-down"></i>
                            </span>

                        </button>
                    </div>

                </div>
            </div>


            <button id="home-icon"
                    class="header-icon-btn"
                    title="Books">
                <i class="fas fa-book-open"></i>
            </button>


            <button id="search-toggle"
                    class="header-icon-btn"
                    title="Search">
                <i class="fas fa-search"></i>
            </button>


            <button id="theme-toggle"
                    class="header-icon-btn"
                    title="Toggle Theme">

                <svg id="moon-icon"
                     width="24"
                     height="24"
                     viewBox="0 0 24 24"
                     fill="none">

                    <path d="M21 12.79A9 9 0 1 1 11.21 3 
                             7 7 0 0 0 21 12.79z"
                          fill="currentColor"
                          stroke="currentColor"
                          stroke-width="2"
                          stroke-linecap="round"
                          stroke-linejoin="round"/>
                </svg>

            </button>

        </div>
    </div>


    <!-- ============================= -->
    <!-- SEARCH CONTAINER UPDATED -->
    <!-- ============================= -->

    <div id="search-container">

        <!-- Scope Dropdown -->
        <div class="search-scope">

            <button id="scope-btn">
                All <i class="fa fa-chevron-down"></i>
            </button>

            <div id="scope-menu">

                <div class="scope-item" data-scope="all">
                    All
                </div>

                <div class="scope-item has-submenu">
                    OT
                    <i class="fa fa-chevron-right"></i>

                    <div class="submenu"
                         id="ot-books">
                        <!-- JS will load OT books -->
                    </div>
                </div>

                <div class="scope-item has-submenu">
                    NT
                    <i class="fa fa-chevron-right"></i>

                    <div class="submenu"
                         id="nt-books">
                        <!-- JS will load NT books -->
                    </div>
                </div>

                <div class="scope-item has-submenu">
                    Books
                    <i class="fa fa-chevron-right"></i>

                    <div class="submenu"
                         id="all-books">
                        <!-- JS will load 66 books -->
                    </div>
                </div>

            </div>

        </div>


        <!-- Search Input -->

        <input type="text"
               id="search-input"
               placeholder="Search with keyword... (ఉదా: ప్రేమ, యేసు)">



        <!-- Search Buttons -->

        <div id="search-buttons">

            <button id="search-icon"
                    title="Search">
            </button>

            <button id="clear-icon"
                    title="Clear">✕
            </button>

        </div>

    </div>


    <div id="result-count"></div>

</div>



<!-- ============================= -->
<!-- NAV HEADER -->
<!-- ============================= -->

<div id="nav-header">

    <button id="prev-chapter-header"
            class="nav-button">←</button>

    <div id="header-title"></div>

    <button id="next-chapter-header"
            class="nav-button">→</button>

</div>



<!-- ============================= -->
<!-- CONTENT -->
<!-- ============================= -->

<div id="content">
    <div class="loading">Loading...</div>
</div>



<!-- ============================= -->
<!-- ZOOM CONTROL -->
<!-- ============================= -->

<div id="zoom-control">

    <button id="zoom-btn"
            class="zoom-button"
            title="Text Size: 100%">

        <i class="fas fa-text-height"></i>
    </button>


    <div id="zoom-panel"
         class="zoom-panel">

        <div class="zoom-header">
            <span class="zoom-label">Text Size</span>
            <span class="zoom-percentage">100%</span>
        </div>

        <input type="range"
               id="zoom-slider"
               class="zoom-slider"
               min="70"
               max="180"
               value="100"
               step="10">

        <div class="zoom-quick-actions">

            <button class="zoom-quick-btn"
                    data-zoom="70">A</button>

            <button class="zoom-quick-btn"
                    data-zoom="100">A</button>

            <button class="zoom-quick-btn"
                    data-zoom="130">A</button>

            <button class="zoom-quick-btn"
                    data-zoom="160">A</button>

        </div>

    </div>

</div>



<script type="module"
        src="./JS/app.js?v=<?php echo $version; ?>">
</script>

</body>
</html>