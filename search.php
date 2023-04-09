<?php define('DIR', __DIR__); include('includefile.php'); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Domaincost.net: Domain Name Price Compare</title>
    <meta name="description" content="Best domain name price comparison website, Compares most popular domain name registrars price at single place." />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="img/favicon-256.png"/>

    <meta property="og:site_name" content="Domain Price Compare" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="http://domaincost.net" />
    <meta property="og:title" content="Domain Name Price Compare" />
    <meta property="og:description" content="Best domain name comparison website, Compares prices of top domain name registrars at one place." />
    <link rel="image_src" content="" />
    <meta property="og:image" content="" />
    <meta property="og:image:type" content="image/png" />

    <meta property="twitter:card" content="summary" />
    <meta property="twitter:title" content="Domain Price Compare" />
    <meta property="twitter:description" content="Best domain name comparison website, compares prices of top domain name registrars at one place." />
    <meta property="twitter:image:src" content="" />


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
    
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/wiselinks-1.2.2.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <script type="text/javascript" src="js/custom.js"></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-123213918-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-123213918-1');
    </script>

  </head>
  <body>
    <section class="tnav tnav_header">
      <div class="container">
        <div class="row">
          <div class="col-8" align="left">
            <a href="/" title="Domaincost.net" class="navbar-brand"><img src="img/logo.png" class="img-fluid" alt="Logo"/></a>
          </div>
          <div class="col-4" align="right">
            <div class="dropdown">
              <button class="dropbtn btn btn-primary"><i class="fa fa-share" aria-hidden="true"></i> Share </button>
              <div class="dropdown-content">
                <a href="javascript:void(0);" onclick="window.open('//www.facebook.com/sharer.php?u=http%3A%2F%2FDomaincost.net&t=Domain%20Price%20Comparison%20Tool','popUpWindow','height=500,width=400,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes')"><i class="fab fa-facebook-square"></i></i> Share on Facebook</a>
                <a href="javascript:void(0);" onclick="window.open('//plus.google.com/share?url=http%3A%2F%2FDomaincost.net','popUpWindow','height=500,width=400,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes')"><i class="fab fa-google-plus-square" aria-hidden="true"></i> Share on Google+</a>
                <a href="javascript:void(0);" onclick="window.open('//twitter.com/share?text=Domain%20Price%20Comparison%20Tool&url=http%3A%2F%2FDomaincost.net','popUpWindow','height=500,width=400,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes')"><i class="fab fa-twitter-square" aria-hidden="true"></i> Share on Twitter</a>
                <a href="javascript:void(0);" onclick="window.open('//www.reddit.com/submit?url=http%3A%2F%2FDomaincost.net','popUpWindow','height=500,width=400,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes')"><i class="fab fa-reddit-square" aria-hidden="true"></i> Share on Reddit</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section>
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <form  class="form-inline form_domain_search" action="search" method="get" id="domain_search_form" data-push="true" data-target="#updateContainer">
              <div class="col-sm-12"><h3 style="margin-bottom: 20px;"><i class="fas fa-rupee-sign"></i></i> Filter Best Price</h3></div>
              <div class="form-group col-sm-6">
                <input name="domain" type="text" class="col-sm-12 form-control" id="domain" placeholder="Enter Your Domain Name" value="<?php echo $domain; ?>" autocapitalize="off" autocomplete="off" autocorrect="off">
              </div>
              <div class="form-group col-sm-3">
                <select class="col-sm-12 form-control" id="exampleFormControlSelect1" name="tld">
                  <option value="">Select TLD's</option>
                  <?php foreach ($tlds as $key => $value) { ?>
                  <option value="<?php echo $value; ?>" <?php echo ($value == $tld) ? 'selected' : ''; ?>><?php echo $value; ?></option>
                  <?php } ?>
                </select>
              </div>
              
              
              <div class="form-group col-sm-3">
                <input type="submit" class="col-sm-12 btn btn-primary" value="Search Domain"/>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
    <section>
      <div class="container">
        <div class="row">
          
          <div class="col-sm-9">
            <div class="hameid-loader-overlay" style="display: none;">
              <div class="loader-img"></div>
            </div>
            <div id="updateContainer">
              <?php echo empty($domain_error) ? '' : '<p style="text-align: center;">' . $domain_error . '</p>'; ?>
              <?php echo empty($tld_error) ? '' : '<p style="text-align: center;">' . $tld_error . '</p>'; ?>
              <?php if( !empty($domain_status) ): ?>
              <div class="tnav2">
                <div class="domain_status  <?php echo $domain_av_status == true ? '' : 'red_buzzer'; ?>">
                  <h3 align="center" class="aval"><?php echo $domain_av_status == true ? '<i class="far fa-thumbs-up"></i>' : '<i class="fas fa-exclamation-circle"></i>'; ?><strong style="margin-left: 10px;"><?php echo $domain_status; ?></strong> </h3>
                </div>
              </div>
              
              <?php if( isset($suggested_domain) && $suggested_domain !== false ): ?>
              <div class="tnav2">
                <div class="col-sm-12 domain-name-suggution">
                  <div class="row">
                    <div class="col-sm-12"><h5> <strong>Suggested One</strong></h5>
                    <hr/></div>
                    
                    <?php foreach ($suggested_domain as $key => $value): $value = (array) $value; ?>
                    <div class="col-sm-6">
                      <div class="row suggested_domain_row">
                        <div class="col-8 overflowtxt" title="<?php echo $value['domain']; ?>"> <span><?php echo $value['domain']; ?></span></div>
                        <div class="col-4"><button type="button" class="btn btn-outline-success" onclick="suggested_price_check('<?php echo $value['domain']; ?>');">Try This</button></div>
                      </div>
                    </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>
              <?php endif; ?>
              
              <?php endif; ?>
              <?php if( isset($data) ): ?>
              <div class="tnav2">
                <table class="table table-bordered table-hover table-responsive">
                  <thead>
                    <tr>
                      <th scope="col">Registrars</th>
                      <th scope="col">1 Year</th>
                      <th scope="col">2 Years</th>
                      <th scope="col">3 Years</th>
                      <th scope="col">4 Years</th>
                      <th scope="col">5 Years</th>
                      <th scope="col">Buy Now</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach( $data as $key => $value ): ?>
                    <?php $value['cost'] = ( ($value['cost'] * 100) + mt_rand(100,1000) ) / 100; ?>
                    <tr>
                      <th title="<?php echo $value['registrar_name']; ?>" scope="row"><img src="img/<?php echo $value['registrar_img']; ?>" class="img-fluid" alt="<?php echo $value['registrar_name']; ?>"/></th>
                      <td><i class="fas fa-rupee-sign" aria-hidden="true"></i> <?php echo number_format( ( $value['cost'] * 1 ), 2); ?></td>
                      <td><i class="fas fa-rupee-sign" aria-hidden="true"></i> <?php echo number_format( ( $value['cost'] * 2 ), 2); ?></td>
                      <td><i class="fas fa-rupee-sign" aria-hidden="true"></i> <?php echo number_format( ( $value['cost'] * 3 ), 2); ?></td>
                      <td><i class="fas fa-rupee-sign" aria-hidden="true"></i> <?php echo number_format( ( $value['cost'] * 4 ), 2); ?></td>
                      <td><i class="fas fa-rupee-sign" aria-hidden="true"></i> <?php echo number_format( ( $value['cost'] * 5 ), 2); ?></td>
                      <td><button type="button" class="btn btn-success btn-sm">Buy Now</button></td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
              <?php else: ?>
              <div class="row">
                <div class="col-sm-12">
                  <div class="tnav2">
                    <div class="row">
                      <div class="col-2" align="center">
                        <i class="fas fa-balance-scale fa-3x"></i>
                      </div>
                      <div class="col-10">
                        <h1>Domain Price Compare – Choose Best Domain Registrar</h1>
                        <p>Compare different domain prices among industry top registrars within single shot. We compare prices of all the domain registrar quickly and easily as much as possible. We do compare domain prices of top 12 registrar and moving further to enhance the list. Currently our supported domain TLD's are (<strong>.com, .org, .net, .us, .info, .co, .co.in, .in, .uk, .net.in</strong>) and growing further. We support comparison for 5 years of domain termlength.</p>
                      </div>
                    </div><hr>
                    <div class="row">
                      <div class="col-2" align="center">
                        <i class="fas fa-question-circle fa-3x" aria-hidden="true"></i>
                      </div>
                      <div class="col-10">
                        <h1>Domaincost.net - Why we built it?</h1>
                        <p>Being a developer it's too hectic to browse different registrar's website and check, who provides best prices in the industry. We built this for developers, companies and freelancers (Begineer or Expert) to comapre and analyze best domain registrar easy and seamless in the industry.</p>
                      </div>
                    </div>
                    
                  </div>
                </div>
                
                <div class="col-sm-6">
                  <div class="tnav1">
                    <div>
                      <div class="card-body">
                        <a href="https://www.entrepreneur.com/article/231331">
                          <h5 class="card-title">How to Choose a Domain Registrar</h5>
                        </a>
                        <div class="datetime" style="color: #a3abaf; margin-bottom: 10px; font-size: 12px;"> Friday, 20 July 2018 08:50 </div>
                        <p class="card-text">Learn how to select the best domain registrar that meets your needs. Use our tips for choosing the right domain name registrar that has your best interests in</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="tnav1">
                    <div>
                      <div class="card-body">
                        <a href="https://www.cnet.com/how-to/how-to-choose-a-web-hosting-provider/">
                          <h5 class="card-title">How to Choose a Web Hosting Provider</h5>
                        </a>
                        <div class="datetime" style="color: #a3abaf; margin-bottom: 10px; font-size: 12px;"> Friday, 20 July 2018 09:50 </div>
                        <p class="card-text">Picking a good hosting provider boils down to three S's -- speed, support and security. For good measure, scale may be another S-word to ponder.</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php endif; ?>
            </div>
          </div>
          <div class="col-sm-3" style="margin-bottom: 10px;" align="center">
            <a href="//bigrock-in.sjv.io/c/1272403/401909/5632"><img src="//a.impactradius-go.com/display-ad/5632-401909" border="0" alt="" width="200" height="200"/></a><img height="0" width="0" src="//bigrock-in.sjv.io/i/1272403/401909/5632" style="position:absolute;visibility:hidden;" border="0" />
            <hr/>
            <a href="http://www.jdoqocy.com/click-8854851-10833452" target="_top">
<img src="http://www.ftjcfx.com/image-8854851-10833452" width="300" height="250" alt="1and1.com | Hosting, Domains, Website Services & Servers" border="0"/></a>
          </div>
        </div>
      </div>
    </section>
    <!-- Footer -->
    <footer class="page-footer font-small dark darken-3" style="background-color:#000; color:#fff; text-align:center;">
      
      <!-- Copyright -->
      <div class="footer-copyright text-center py-3">© 2018 Copyright: Domaincost.net
      </div>
      <!-- Copyright -->
    </footer>
    <!-- Footer -->
  </body>
</html>