<div class="thsa_qg_wrapper thsa_qg_settings_wrapper">
    <div class="thsa_qg_inner">
        <h2><?php esc_html_e('Subscriptions', 'thsa-quote-generator'); ?></h2>
    </div>
    <table class="wp-list-table widefat fixed striped table-view-list">
        <thead>
            <tr>
                <th width="70%">Title</th>
                <th width="15%">Author</th>
                <th width="15%">Date Published</th>
            </tr>
        </thead>
        <tbody>
            <?php if( isset( $params['data'] ) ): 
                    foreach( $params['data'] as $quote ):    
            ?>
            <tr>
                <td><a href="<?php echo esc_url( $quote['edit'] ); ?>" target="_blank"><?php esc_html_e( $quote['title'] ); ?></a></td>
                <td><?php esc_html_e( $quote['author'] ); ?></td>
                <td><?php esc_html_e( $quote['date'] ); ?></td>
            </tr>
            <?php 
                    endforeach;
                endif; ?>
        </tbody>
    </table>
</div>