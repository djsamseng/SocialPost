            <div class="banner-hold">
                <div class="banner-logo">Logo here</div>
                <div class="banner-element">
                    <div class="feed">
                        <a href="#"><div class="dropdown-header">Feed</div></a>
                        <a class="drop" href="#">Feed Data</a>
                    </div>
                </div>
                <div class="banner-element">
                    <div class="messages">
                        <a href="#"><div class="dropdown-header">Messages</div></a>
                        <a class="drop" href="#">Message Data</a>
                    </div>
                </div>
                <div class="banner-element">
                    <div class="mapit">
                        <a href="#"><div class="dropdown-header">MapIt</div></a>
                        <a class="drop" href="#">Map Data</a>
                    </div>
                </div> 
                <div class="banner-user">
                    <div class="user-options">
                        <div class="dropdown-header">00</div>
                        <a class="drop" href="#">Settings</a>
                        <a class="drop" href="?page=logout">Logout</a>
                    </div>
                    <div class="user-profile">
                        <a href="#"><div class="dropdown-header-profile"><?php if (isset($name)) {echo $name;}else{echo "Profile";}?></div></a>
                        <a class="drop" href="#">Home</a>
                        <a class="drop" href="#">Profile</a>
                    </div>
                </div>
            </div>
