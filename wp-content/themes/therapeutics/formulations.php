<?php 
/* Template Name: formulation */
get_header(); ?>


<section class="light-gray step-wrapper">
      <div class="step2 text-center">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <h2 class="inner_page_title">
              	Commonly Used Formulations |<span>Please check the appropriate box for desired medication and refills.</span></h2>

              <div class="step2-btn-group">
                <?php $formulations = get_posts(
                array( 'post_type'=>'formulations', 'posts_per_page'=>-1 ,'orderby'=>'title','order'=>'ASC') ); 
                
                ?>
                
                <?php foreach ($formulations as $key => $cat): ?>
                  <a href="<?php echo get_the_permalink($cat->ID) ;?>" class="btn btn-primary">
                    <?php echo $cat->post_title . '*'; ?></a>
                  <?php endforeach; ?>

              </div>
            </div>

            <div class="col-md-12">
              <div class="alternative-table">
                <div class="table-head primary-block">alternative therapy table*</div>
                <div class="table-content light-block">
                  <p>D-1 – Diclofenac 1.5% Solution | <span class="primary-highlight">Qty: 300mL; Sig: Apply 2.5 mL (approx. 40 drops) to the affected area 3-4 times daily</span></p>
                  <p>
                    L-1 – Lidocaine 5% Ointment  <span class="primary-highlight">Qty: 250g; Sig: Apply 2.5 grams to the affected area 3-4 times daily</span>
                  </p>
                  <p>
                    CA-1 – Gabapentin 2% Celecoxib 3% Acetaminophen 6.5% Butalbital 0.5% Lidocaine 2% Prilocaine 2% Cream <span class="primary-highlight">Qty: 240g; Sig: Apply 2 grams to the affected area 3-4 times daily</span>
                  </p>
                  <p>
                    CA-2 – Ketoprofen 5% Lidocaine 2% Cyclobenzaprine 2% Amitriptyline 2% Cream | <span class="primary-highlight">Qty: 240g; Sig: Apply 2 grams to the affected area 3-4 times daily</span>
                  </p>
                  <p>
                    S-1 – Fluocinonide 0.1% Cream | <span class="primary-highlight">Qty: 120g; Sig:Apply 2 grams to the affected area 1-2 times daily</span>
                  </p>
                  <p>
                    S-2 – Tamoxifen 0.1% Tranilast 1% Caffeine 0.1% Lipoic Acid 0.5% Cream | <span class="primary-highlight">Qty: 120g; Sig: Apply 2 grams to the affected area 1-2 times daily</span>
                  </p>
                  <p>
                    KB-1 – Ketoprofen 10% Baclofen 2% Cyclobenzaprine 2% Lidocaine 5% | <span class="primary-highlight">Qty: 120g; Sig: Apply 2 grams to the affected area 1-2 times daily</span>
                  </p>

                </div>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </section>


<?php get_footer(); ?>