<article class="company pm-list-item" data-entity="<?php echo $item->id; ?>">

    <aside>

        <div class="image-container<?php echo empty($item->profile_image) ? " noimage" : "" ;?>">
            <?php
            if (!empty($item->profile_image)) {
                ?>
                <img class="image" src="<?php echo $imagesBaseURL . $item->profile_image; ?>">
                <?php
            }
            else {
                ?>
                <p class="initials"></p>
                <?php
            }
            ?>
        </div>

    </aside>

    <main>

        <div class="info">

            <div class="main-data">
                <div class="name">
                    <?php echo $item->name; ?>
                </div>
            </div>

            <div class="visibility closed">
                <a class="open-details link" href="#"><?php esc_html_e( 'View details', $this->pluginName); ?></a>
                <a class="close-details link" href="#"><?php esc_html_e( 'Hide details', $this->pluginName); ?></a>
                <div class="arrow"></div>
            </div>

        </div>

        <div class="details closed">
            <div class="website">
                <a href="<?php echo $item->website; ?>" target="_blank"><?php echo $item->website; ?></a>
            </div>
            <div class="country">
                <?php echo $item->country->name; ?>
            </div>
            <div class="profile<?php echo (trim($item->profile) != '' ? ' filled' : ''); ?>">
                <?php echo $item->profile; ?>
            </div>
        </div>

    </main>

</article>