<?php

$config = array(
  'shards' => array(
    array(
      'name' => 'General',

      // slave gametool DB for shard
      'db_host' => "192.168.0.10",
      'db_port' => 5432,
      'db_name' => "slave_gametool",
      'db_login' => "gmtool",
      'db_password' => "gmtool",

      'accounts_file_name' => 'accounts.txt'  // for multiSendMail2 example
    ),
    /* you can specify other shards same way:

    array(
      'name' => 'Other Shard',
      ...
    )
    */    
  ),

  'master_gametool_web_host' => '192.168.0.15',
  'master_gametool_web_port' => 8088,
  'master_gametool_username' => 'admin',
  'master_gametool_password' => '1',

  'gifts' => array(
    'classes' => array(
      61117 => array(
        'class' => 'Warrior',
        'item' => 'Holy Charm',
        'resource_id' => 156232704,
        'stack_count' => 99
      ),
      61119 => array(
        'class' => 'Priest',
        'item' => 'Holy Charm',
        'resource_id' => 156232704,
        'stack_count' => 99
      ),
      61121 => array(
        'class' => 'Necromancer',
        'item' => 'Dusty Sackcloth Shirt',
        'resource_id' => 103713941,
        'stack_count' => 1
      ),
    ),
  ),

  // for multiSendMail2 example
  'single_gift' => array(
     'item' => 'Holy Charm',
     'resource_id' => 156232704,
     'stack_count' => 99
   ),

   // for multiSendMail2 example
   'only_max_level' => true,

  'sender_name' => 'GiftMan',
  'subject' => 'Thanks for playing',
  'body' => 'Please let us present this item to you! Use it to empower yourself more!',

  'from_seconds' => mktime(0 /* hour */, 0 /* minute */, 0 /* second */, 8 /* month */, 4 /* day */, 2011),
  'login_days' => 1,
);

?>