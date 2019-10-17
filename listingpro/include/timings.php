<div class="open-hours">
	<!-- <h2><?php echo esc_html__('Opening Hours', 'listingpro');?></h2> -->
	<?php
	global $listingpro_options;
	$listing_mobile_view    =   $listingpro_options['single_listing_mobile_view'];
	$format = $listingpro_options['timing_option'];
		$buisness_hours = listing_get_metabox('business_hours');
		
		if(!empty($buisness_hours) && is_array($buisness_hours)){
				$lat = listing_get_metabox('latitude');
				$long = listing_get_metabox('longitude');
			//$timezone = getClosestTimezone($lat, $long);
			
			/* echo '<pre>';
			print_r($buisness_hours);
			echo '</pre>';  */
			$timezone  = get_option('gmt_offset');
			$time = gmdate("H:i", time() + 3600*($timezone+date("I"))); 
			$day =  gmdate("l");
			//echo $time;
			$lang = get_locale();
			setlocale(LC_ALL, $lang.'.utf-8');
			$day = strftime("%A");
			$day = date_i18n( 'l', strtotime( '11/15-1976' ) );
			$day = ucfirst($day);
			$time = strtotime($time);
			$twodays = array();
			$todayOFF = true;
			$todayIsOpen = false;
			$todaycompleteopend = false;
			$newTimeOpen;
			$newTimeClose;
			$newTimeOpen1;
			$newTimeClose1;
			$totimesinaday = false;
			
			echo '<div class="today-hrs pos-relative"><ul>';
			$dayName = esc_html__('Today','listingpro');
			foreach($buisness_hours as $key=>$value){
				$keyArray[] = $key;
				
				if ( (strpos($key, "$day-") !== false) || (strpos($key, "-$day") !== false) ) {
					/* double day values */
					$twodays = explode('-', $key);
					list($dayToday) = explode('-', $key);
					if( !empty($value['open']) && !empty($value['close']) ){
						
						/* if array */
						if( is_array($value['open']) && is_array($value['close']) ){
							$todayOFF = false;
							$lpOpen1 = '';
							$lpOpen2 = '';
							$lpClose1 = '';
							$lpClose2 = '';
							if( isset($value['open'][0]) && isset($value['close'][0]) ){
								if( !empty($value['open'][0]) && !empty($value['close'][0]) ){
									$lpOpen1 = $value['open'][0];
									$lpClose1 = $value['close'][0];
									$opencheck = $lpOpen1;
									$closecheck = $lpClose1;
									
									$lpOpen1 = str_replace(' ', '', $lpOpen1);
									$lpClose1 = str_replace(' ', '', $lpClose1);
									
									$lpOpen1 = strtotime($lpOpen1);
									$lpClose1 = strtotime($lpClose1);
									
									if(!empty($format) && $format == '24'){
										$newTimeOpen = date("H:i", $lpOpen1);
										$newTimeClose = date("H:i", $lpClose1);
									}else{						
										$newTimeOpen = date('h:i A', $lpOpen1);
										$newTimeClose = date('h:i A', $lpClose1);
									}
								
									$todayD = $twodays[0];
									$tomorrowD = $twodays[1];
									
									if($day==$todayD){
										if( ($time > $lpOpen1) ){
											$todayIsOpen = true;
										}
										
									}
									if($day==$tomorrowD){
										if( ($time < $lpClose1) ){
											$todayIsOpen = true;
										}
									}
									
									$nextdayhas = false;
									
									foreach($buisness_hours as $kkey=>$nval){
										if(strpos($key, "-$day") !== false){
											if(strpos($kkey, "$day-") !== false){
												$nextdayhas = true;
											}elseif(strpos($kkey, "$day") !== false){
												$nextdayhas = true;
											}
										}
									}
									
									
									if( ($todayIsOpen==false) && ($nextdayhas==true) ){
										continue;
										
									}else{
									
										if( empty($opencheck) && empty($closecheck) ){
											echo '<li class="today-timing clearfix"><strong>'.listingpro_icons('todayTime').'</strong>';
											echo '<span><a class="Opened">'.esc_html__('24 hours open','listingpro').'</a></span>';
											echo '</li>';
											break;
										}
										elseif($todayOFF==false && $todayIsOpen==true){
											echo '<li class="today-timing clearfix"><strong>'.listingpro_icons('todayTime').'</strong>';
											echo '<a class="Opened">'.esc_html__('Open Now~','listingpro').'</a>';
											if( $listing_mobile_view == 'responsive_view' || !wp_is_mobile() ){
												
												echo '<span>'.$newTimeOpen.' - '.$newTimeClose.'</span></li>';
												
											}
											break;
										}
										
										elseif($todayOFF==false && $todayIsOpen==false){
											echo '<li class="today-timing clearfix"><strong>'.listingpro_icons('todayTime').'</strong>';
											echo '<a class="closed">'.esc_html__('Closed Now!','listingpro').'</a>';
											echo '<span>'.$newTimeOpen.' - '.$newTimeClose.'</span></li>';
											break;
										}
									}
									
								}
								
							}
							
							if( isset($value['open'][1]) && isset($value['close'][1]) ){
								if( !empty($value['open'][1]) && !empty($value['close'][1]) ){
									if( !empty($value['open'][1]) && !empty($value['close'][1]) ){
										$lpOpen2 = $value['open'][1];
										$lpClose2 = $value['close'][1];
										$opencheck = $lpOpen2;
										$closecheck = $lpClose2;
										
										$lpOpen2 = str_replace(' ', '', $lpOpen2);
										$lpClose2 = str_replace(' ', '', $lpClose2);
										
										$lpOpen2 = strtotime($lpOpen2);
										$lpClose2 = strtotime($lpClose2);
										
										if(!empty($format) && $format == '24'){
											$newTimeOpen = date("H:i", $lpOpen2);
											$newTimeClose = date("H:i", $lpClose2);
										}else{						
											$newTimeOpen = date('h:i A', $lpOpen2);
											$newTimeClose = date('h:i A', $lpClose2);
										}
										$todayD = $twodays[0];
										$tomorrowD = $twodays[1];
										
										if($day==$todayD){
											if( ($time > $lpOpen2) ){
												$todayIsOpen = true;
											}
											
										}
										if($day==$tomorrowD){
											if( ($time < $lpClose2) ){
												$todayIsOpen = true;
											}
										}
										
										$nextdayhas = false;
									
										foreach($buisness_hours as $kkey=>$nval){
											if(strpos($key, "-$day") !== false){
												if(strpos($kkey, "$day-") !== false){
													$nextdayhas = true;
												}elseif(strpos($kkey, "$day") !== false){
													$nextdayhas = true;
												}
											}
										}
										
										
										if( ($todayIsOpen==false) && ($nextdayhas==true) ){
											continue;
											
										}else{
										
											if( empty($opencheck) && empty($closecheck) ){
												echo '<li class="today-timing clearfix"><strong>'.listingpro_icons('todayTime').'</strong>';
												echo '<span><a class="Opened">'.esc_html__('24 hours open','listingpro').'</a></span>';
												echo '</li>';
												break;
											}
											elseif($todayOFF==false && $todayIsOpen==true){
												echo '<li class="today-timing clearfix"><strong>'.listingpro_icons('todayTime').'</strong>';
												echo '<a class="Opened">'.esc_html__('Open Now~','listingpro').'</a>';
												if( $listing_mobile_view == 'responsive_view' || !wp_is_mobile() ){
													
													echo '<span>'.$newTimeOpen.' - '.$newTimeClose.'</span></li>';
													
												}
												break;
											}
											
											elseif($todayOFF==false && $todayIsOpen==false){
												
												echo '<li class="today-timing clearfix"><strong>'.listingpro_icons('todayTime').'</strong>';
												echo '<a class="closed">'.esc_html__('Closed Now!','listingpro').'</a>';
												echo '<span>'.$newTimeOpen.' - '.$newTimeClose.'</span></li>';
												break;
											}
										}
										
										
										
									}
								}
								
							}
						}
						/* if not array */
						else{
							
							$lpOpen = '';
							$lpClose = '';
							if( isset($value['open']) && isset($value['close']) ){
								if( !empty($value['open']) && !empty($value['close']) ){
									$todayOFF = false;
									$lpOpen = $value['open'];
									$lpClose = $value['close'];
									$opencheck = $lpOpen;
									$closecheck = $lpClose;
									
									$lpOpen = str_replace(' ', '', $lpOpen);
									$lpClose = str_replace(' ', '', $lpClose);
									
									$lpOpen = strtotime($lpOpen);
									$lpClose = strtotime($lpClose);
									
									if(!empty($format) && $format == '24'){
										$newTimeOpen = date("H:i", $lpOpen);
										$newTimeClose = date("H:i", $lpClose);
									}else{						
										$newTimeOpen = date('h:i A', $lpOpen);
										$newTimeClose = date('h:i A', $lpClose);
									}
									
									$todayD = $twodays[0];
									$tomorrowD = $twodays[1];
									/* echo '<br>';
									echo $tomorrowD; */
								
									if($day==$todayD){
										if( ($time > $lpOpen) ){
											$todayIsOpen = true;
										}
										
									}
									if($day==$tomorrowD){
										if( ($time < $lpClose) ){
											$todayIsOpen = true;
										}
									}
									
									$nextdayhas = false;
									
									foreach($buisness_hours as $kkey=>$nval){
										if(strpos($key, "-$day") !== false){
											if(strpos($kkey, "$day-") !== false){
												$nextdayhas = true;
											}elseif(strpos($kkey, "$day") !== false){
												$nextdayhas = true;
											}
										}
									}
									
									
									if( ($todayIsOpen==false) && ($nextdayhas==true) ){
										continue;
										
									}else{
									
										if( empty($opencheck) && empty($closecheck) ){
											echo '<li class="today-timing clearfix"><strong>'.listingpro_icons('todayTime').'</strong>';
											echo '<span><a class="Opened">'.esc_html__('24 hours open','listingpro').'</a></span>';
											echo '</li>';
											break;
										}
										elseif($todayOFF==false && $todayIsOpen==true){
											echo '<li class="today-timing clearfix"><strong>'.listingpro_icons('todayTime').'</strong>';
											echo '<a class="Opened">'.esc_html__('Open Now~','listingpro').'</a>';
											if( $listing_mobile_view == 'responsive_view' || !wp_is_mobile() ){
												
												echo '<span>'.$newTimeOpen.' - '.$newTimeClose.'</span></li>';
												
											}
											break;
										}
										
										elseif($todayOFF==false && $todayIsOpen==false){
											echo '<li class="today-timing clearfix"><strong>'.listingpro_icons('todayTime').'</strong>';
											echo '<a class="closed">'.esc_html__('Closed Now!','listingpro').'</a>';
											echo '<span>'.$newTimeOpen.' - '.$newTimeClose.'</span></li>';
											break;
										}
									}
									
								}
								
							}
							
						}
					}
					
				}
				else{
					/* single day values */
					if( !empty($value['open']) && !empty($value['close']) ){
						/* if array */
						if( is_array($value['open']) && is_array($value['close']) ){
							if($day == $key){
								$todayOFF = false;
								$lpOpen1 = '';
								$lpOpen2 = '';
								$lpClose1 = '';
								$lpClose2 = '';
								if( isset($value['open'][0]) && isset($value['close'][0]) ){
									if( !empty($value['open'][0]) && !empty($value['close'][0]) ){
										$lpOpen1 = $value['open'][0];
										$lpClose1 = $value['close'][0];
										$opencheck = $lpOpen1;
										$closecheck = $lpClose1;
										
										$lpOpen1 = str_replace(' ', '', $lpOpen1);
										$lpClose1 = str_replace(' ', '', $lpClose1);
										
										$lpOpen1 = strtotime($lpOpen1);
										$lpClose1 = strtotime($lpClose1);
										
										if(!empty($format) && $format == '24'){
											$newTimeOpen = date("H:i", $lpOpen1);
											$newTimeClose = date("H:i", $lpClose1);
										}else{						
											$newTimeOpen = date('h:i A', $lpOpen1);
											$newTimeClose = date('h:i A', $lpClose1);
										}
										
										if( $time > $lpOpen1 && $time < $lpClose1 ){
											$todayIsOpen = true;
										}
										
										if( ($todayIsOpen==false) && (isset($value['open'][1]) && isset($value['close'][1]) ) ){
										
										}else{
										
											if( empty($opencheck) && empty($closecheck) ){
												echo '<li class="today-timing clearfix"><strong>'.listingpro_icons('todayTime').'</strong>';
												echo '<span><a class="Opened">'.esc_html__('24 hours open','listingpro').'</a></span>';
												echo '</li>';
												break;
											}
											elseif($todayOFF==false && $todayIsOpen==true){
												echo '<li class="today-timing clearfix"><strong>'.listingpro_icons('todayTime').'</strong>';
												echo '<a class="Opened">'.esc_html__('Open Now~','listingpro').'</a>';
												if( $listing_mobile_view == 'responsive_view' || !wp_is_mobile() ){
													
													echo '<span>'.$newTimeOpen.' - '.$newTimeClose.'</span></li>';
													
												}
												break;
											}
											
											elseif($todayOFF==false && $todayIsOpen==false){
												echo '<li class="today-timing clearfix"><strong>'.listingpro_icons('todayTime').'</strong>';
												echo '<a class="closed">'.esc_html__('Closed Now!','listingpro').'</a>';
												echo '<span>'.$newTimeOpen.' - '.$newTimeClose.'</span></li>';
												break;
											}
										}
										
									}
								}
								
								if( isset($value['open'][1]) && isset($value['close'][1]) ){
									if( !empty($value['open'][1]) && !empty($value['close'][1]) ){
										if( !empty($value['open'][1]) && !empty($value['close'][1]) ){
											$lpOpen2 = $value['open'][1];
											$lpClose2 = $value['close'][1];
											$opencheck = $lpOpen2;
											$closecheck = $lpClose2;
											
											$lpOpen2 = str_replace(' ', '', $lpOpen2);
											$lpClose2 = str_replace(' ', '', $lpClose2);
											
											$lpOpen2 = strtotime($lpOpen2);
											$lpClose2 = strtotime($lpClose2);
											
											if(!empty($format) && $format == '24'){
												$newTimeOpen = date("H:i", $lpOpen2);
												$newTimeClose = date("H:i", $lpClose2);
											}else{						
												$newTimeOpen = date('h:i A', $lpOpen2);
												$newTimeClose = date('h:i A', $lpClose2);
											}
											if( $time > $lpOpen2 && $time < $lpClose2 ){
												$todayIsOpen = true;
											}
											
											
											if( empty($opencheck) && empty($closecheck) ){
												echo '<li class="today-timing clearfix"><strong>'.listingpro_icons('todayTime').'</strong>';
												echo '<span><a class="Opened">'.esc_html__('24 hours open','listingpro').'</a></span>';
												echo '</li>';
												break;
											}
											elseif($todayOFF==false && $todayIsOpen==true){
												echo '<li class="today-timing clearfix"><strong>'.listingpro_icons('todayTime').'</strong>';
												echo '<a class="Opened">'.esc_html__('Open Now~','listingpro').'</a>';
												if( $listing_mobile_view == 'responsive_view' || !wp_is_mobile() ){
													
													echo '<span>'.$newTimeOpen.' - '.$newTimeClose.'</span></li>';
													
												}
												break;
											}
											
											elseif($todayOFF==false && $todayIsOpen==false){
												echo '<li class="today-timing clearfix"><strong>'.listingpro_icons('todayTime').'</strong>';
												echo '<a class="closed">'.esc_html__('Closed Now!','listingpro').'</a>';
												echo '<span>'.$newTimeOpen.' - '.$newTimeClose.'</span></li>';
												break;
											}
											
											
											
										}
									}
									
								}
							}	
							
						}
						/* if not array */
						else{
							
							if($day == $key){
							
								$opencheck = $value['open'];
								$open = $value['open'];
								$open = str_replace(' ', '', $open);
								$close = $value['close'];
								$closecheck = $value['close'];
								$close = str_replace(' ', '', $close);
								
								if(!empty($open) && !empty($close)){
									$todayOFF=false;
									$open = strtotime($open);
									$close = strtotime($close);
									if(!empty($format) && $format == '24'){
										$newTimeOpen = date("H:i", $open);
										$newTimeClose = date("H:i", $close);
									}else{						
										$newTimeOpen = date('h:i A', $open);
										$newTimeClose = date('h:i A', $close);
									}
									if( $time > $open && $time < $close ){
										$todayIsOpen = true;
									}
									
									if( empty($opencheck) && empty($closecheck) ){
										echo '<li class="today-timing clearfix"><strong>'.listingpro_icons('todayTime').'</strong>';
										echo '<span><a class="Opened">'.esc_html__('24 hours open','listingpro').'</a></span>';
										echo '</li>';
										break;
									}
									elseif($todayOFF==false && $todayIsOpen==true){
										echo '<li class="today-timing clearfix"><strong>'.listingpro_icons('todayTime').'</strong>';
										echo '<a class="Opened">'.esc_html__('Open Now~','listingpro').'</a>';
										if( $listing_mobile_view == 'responsive_view' || !wp_is_mobile() ){
											
											echo '<span>'.$newTimeOpen.' - '.$newTimeClose.'</span></li>';
											
										}
										break;
									}
									
									elseif($todayOFF==false && $todayIsOpen==false){
										echo '<li class="today-timing clearfix"><strong>'.listingpro_icons('todayTime').'</strong>';
										echo '<a class="closed">'.esc_html__('Closed Now!','listingpro').'</a>';
										echo '<span>'.$newTimeOpen.' - '.$newTimeClose.'</span></li>';
										break;
									}
											
								}
								
							}
						}
					}
					else{
						if($day == $key){
							$todayOFF=false;
							echo '<li class="today-timing clearfix"><strong>'.listingpro_icons('todayTime').esc_html__('Today', 'listingpro').'</strong>';
							echo '<span><a class="Opened">'.esc_html__('24 hours open','listingpro').'</a></span>';
							echo '</li>';
							break;
						}else{
							continue;
						}
					}
				}
				
			}
			
			if($todayOFF == true){
				echo '<li class="today-timing clearfix"><strong>'.listingpro_icons('todayTime').' '.$day.'</strong>';
				echo '<span><a class="closed dayoff">'.esc_html__('Day Off!','listingpro').'</a></span></li>';
			}
			
			echo '</ul>';
			
			/*===============================open time section ends=================== */
			
			
			if( $listing_mobile_view == 'app_view' && wp_is_mobile() ){
                echo '<a href="#" class="show-all-timings">'.esc_html__('Show More','listingpro').'</a>';
            }
            else{
                echo '<a href="#" class="show-all-timings">'.esc_html__('Show all timings','listingpro').'</a>';
            }
			echo '<ul class="hidding-timings">';
			
			foreach($buisness_hours as $key=>$value){
				$dayName = $key;
				if( !empty($value['open']) && is_array($value['open']) && !empty($value['close']) && is_array($value['close']) ){
					/* double time */
					$twodays = explode('-', $key);
					
					if (strpos($key, '-') !== false) {
					}
					else{
						echo '<li class="clearfix lpdoubltimes"><strong>'.$dayName.'</strong>';
						if( isset($value['open'][0]) && isset($value['close'][0]) ){
							if( !empty($value['open'][0]) && !empty($value['close'][0]) ){
								$openlp1 = str_replace(' ', '', $value['open'][0]);
								$closelp1 = str_replace(' ', '', $value['close'][0]);
								$openlp1 = strtotime($openlp1);
								$closelp1 = strtotime($closelp1);
								if(!empty($format) && $format == '24'){
									$newTimeOpen = date("H:i", $openlp1);
									$newTimeClose = date("H:i", $closelp1);
								}else{						
									$newTimeOpen = date("h:i A", $openlp1);
									$newTimeClose = date("h:i A", $closelp1);
								}
								echo '<span>'.$newTimeOpen;
								echo ' - '.$newTimeClose.'</span>';
								
								foreach($buisness_hours as $keyy=>$valuee){
									if(strpos($key, "-$day") !== false){
										if (strpos($keyy, '-') !== false) {
											list($dayName) = explode('-', $dayName);
											if($key==$dayName){
												if( isset($valuee['open'][0]) && isset($valuee['close'][0]) ){
													if( !empty($valuee['open'][0]) && !empty($valuee['close'][0]) ){
														$newTimeOpend = '';
														$newTimeClosed = '';
														$openlpp1 = str_replace(' ', '', $valuee['open'][0]);
														$closelpp1 = str_replace(' ', '', $valuee['close'][0]);
														$openlpp1 = strtotime($openlpp1);
														$closelpp1 = strtotime($closelpp1);
														if( !empty($openlpp1) && !empty($closelpp1) ){
															if(!empty($format) && $format == '24'){
																$newTimeOpend = date("H:i", $openlpp1);
																$newTimeClosed = date("H:i", $closelpp1);
															}else{						
																$newTimeOpend = date("h:i A", $openlpp1);
																$newTimeClosed = date("h:i A", $closelpp1);
															}
															echo '<em>'.$newTimeOpend;
															echo ' - '.$newTimeClosed.'</em>';
														}
														
														
													}
												}
												if( isset($valuee['open'][1]) && isset($valuee['close'][1]) ){
													if( !empty($valuee['open'][1]) && !empty($valuee['close'][1]) ){
														$openlpp2 = str_replace(' ', '', $valuee['open'][1]);
														$closelpp2 = str_replace(' ', '', $valuee['close'][1]);
														$openlpp2 = strtotime($openlpp2);
														$closelpp2 = strtotime($closelpp2);
														if(!empty($format) && $format == '24'){
															$newTimeOpen = date("H:i", $openlpp2);
															$newTimeClose = date("H:i", $closelpp2);
														}else{						
															$newTimeOpen = date("h:i A", $openlpp2);
															$newTimeClose = date("h:i A", $closelpp2);
														}
														
														echo '<em>'.$newTimeOpen;
														echo ' - '.$newTimeClose.'</em>';
													}
												}
												break;
											}
										}
									}
								}
							}
						}
						
						if( isset($value['open'][1]) && isset($value['close'][1]) ){
							if( !empty($value['open'][1]) && !empty($value['close'][1]) ){
								$openlp1 = str_replace(' ', '', $value['open'][1]);
								$closelp1 = str_replace(' ', '', $value['close'][1]);
								$openlp1 = strtotime($openlp1);
								$closelp1 = strtotime($closelp1);
								if(!empty($format) && $format == '24'){
									$newTimeOpen = date("H:i", $openlp1);
									$newTimeClose = date("H:i", $closelp1);
								}else{						
									$newTimeOpen = date("h:i A", $openlp1);
									$newTimeClose = date("h:i A", $closelp1);
								}
								
								echo '<em>'.$newTimeOpen;
								echo ' - '.$newTimeClose.'</em>';
							}
						}
						echo '</li>';
					}
					
				}
				else{
					/* single time */
					$opencheck = $value['open'];
					$open = $value['open'];
					$open = str_replace(' ', '', $open);
					$close = $value['close'];
					$closecheck = $value['close'];
					$close = str_replace(' ', '', $close);
					$open = strtotime($open);
					$close = strtotime($close);
					if(!empty($format) && $format == '24'){
						$newTimeOpen = date("H:i", $open);
						$newTimeClose = date("H:i", $close);
					}else{						
						$newTimeOpen = date('h:i A', $open);
						$newTimeClose = date('h:i A', $close);
					}
					list($dayName) = explode('-', $dayName);
					echo '<li><strong>'.$dayName.'</strong>';
					if(!empty($opencheck)&& !empty($closecheck)){
						echo '<span>'.$newTimeOpen.' - '.$newTimeClose.'</span></li>';
					}
					else{
						echo '<span class="Opened">'.esc_html__('24 hours open', 'listingpro').'</span></li>';
					}
				}
				
				
			}
			echo '</ul>';
			echo '</div>';
			
		}
		
	?>
</div>
