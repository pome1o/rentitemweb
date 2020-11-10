</head>

<body>
    <?php
        $chmod = -1;
        $color = "is-dark";
        if(isset($_SESSION['chmod'])){
            global $color;
            $chmod = $_SESSION['chmod'];            
            switch($chmod){
                case 1:
                $color = "is-warning";
                break;
                case 2:
                $color = "is-success";
                break;
                case 3:
                $color = "is-info";
                break;                
            }
        }
        
    ?>
    <nav class="navbar <?php echo $color; ?> is-fixed-top" style="font-size: 18px; font-weight:bold;">
        <div class="navbar-brand">
            <a class="navbar-item" href="#">資訊管理系</a>
            <a id="navbar-burger" class="button navbar-burger" data-target="navdata">
                <span></span>
                <span></span>
                <span></span>
            </a>
        </div>
        <div class="navbar-menu" id="navdata">
            <div class="navbar-start">
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">借用</a>
                    <div class="navbar-dropdown" style="font-size: 18px; font-weight:bold;">
                        <a class="navbar-item" href="/boom/borrowitem.php?borrow_type=item" onclick="return checklog()">設備</a>
                        <a class="navbar-item" href="/boom/borrowitem.php?borrow_type=class" onclick="return checklog()">教室</a>
                        <a class="navbar-item" href="/boom/borrowitem.php?borrow_type=lab" onclick="return checklog()">實驗室</a>
                    </div>
                </div>
                                     
                   
               
                <?php
                
               if(isset($_COOKIE["comein"]) && $_COOKIE['comein'] == "True" && isset($_SESSION['chmod'])){
                    $chmod = $_SESSION["chmod"];
                    
                // todo 檢查權限 
                    if($chmod == 2 || $chmod == 3 || $chmod == 5){
                        
                        echo "<div class='navbar-item has-dropdown is-hoverable'>";                    
                        echo "<a class='navbar-link'>管理者</a>";
                        echo "<div class='navbar-dropdown' style='font-size: 18px; font-weight:bold;'>";
                        echo "<a class='navbar-item' href='/boom/borrowconfirm.php'>確認借用</a>";
                        echo "<a class='navbar-item' href='/boom/return_borrow.php'>歸還</a>";               
                        echo "<a class='navbar-item' href='/boom/newitem.php'>新增用品</a>";
                        echo "<a class='navbar-item' href='/boom/deletitem.php'>刪除用品</a>";
                        echo "<a class='navbar-item' href='/boom/add_lab.php'>新增實驗室</a>";
                        echo "<a class='navbar-item' href='/boom/del_lab.php'>刪除實驗室</a>";
                        echo "<a class='navbar-item' href='/boom/item_manager.php'>停用設定</a>";
                        echo "<a class='navbar-item' href='/boom/update_class.php'>教室課表更新</a>";
                        echo "<a class='navbar-item' href='/boom/show_item.php?data_cate=item'>查詢</a>"; 
                        echo "<a class='navbar-item' href='/boom/report.php'>報表</a>";  
                        echo "<a class='navbar-item' href='/boom/account_manage/account_main.php'>帳號</a>";
                        echo "</div></div>";
                    }       
                    echo "<a class='navbar-item' href='/boom/user_info.php'>個人帳號</a>";
                    echo "<a class='navbar-item' href='#'>".$_SESSION['user_name']."</a>";
                    echo "<a class='navbar-item' href='/boom/logout.php'>登出</a>";                   
               }
                else{
                    echo "<a class='navbar-item' href='/boom/index.php'>登入</a>";
                }        
            ?>
            </div>
        </div>
        
    </nav>
