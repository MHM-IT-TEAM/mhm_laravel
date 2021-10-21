<template>
  <div>
    <div class="container-fluid">
      <div class="m-3">
        <div class="row">
          <div class="col-sm-12 col-md-4 col-lg-2" id="leftSide">
            <div class="form-group">
              <label for="dateInput" class="mb-0">Date</label>
              <input
                type="date"
                class="form-control"
                name="dateInput"
                id="dateInput"
              />
            </div>
            <div class="form-group">
              <label for="medic" class="mb-0">Laboratory</label>
              <select class="form-select form-control" name="medic" id="medic">
                <option value="none">-none-</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
              </select>
            </div>
            <div class="form-group">
              <label for="note" class="mb-0">Note</label>
              <textarea
                class="form-control"
                name=""
                id=""
                cols="30"
                rows="10"
              ></textarea>
            </div>
          </div>
          <div class="col-sm-12 col-md-4 col-lg-2">
            <div class="head mb-2 mt-2">
              <span>BODY FLUIDS</span>
            </div>
            <div
              class="form-check"
              v-for="(drug, index) in drugs.bodyFluids"
              :key="index"
            >
              <input
                class="form-check-input"
                type="checkbox"
                v-model="drug.status"
              />
              <label>{{ drug.name }} </label>
            </div>
          </div>
          <div class="col-sm-12 col-md-4 col-lg-2">
            <div class="head mb-2 mt-2">
              <span>DRUG ALCOHOL</span>
            </div>
            <div
              class="form-check"
              v-for="(drug, index) in drugs.drugAlcohol"
              :key="index"
            >
              <input
                class="form-check-input"
                type="checkbox"
                v-model="drug.status"
              />
              <label>{{ drug.name }} </label>
            </div>
          </div>
          <div
            class="col-sm-12 col-md-4 col-lg-2 overflow-auto"
            style="max-height: 600px"
          >
            <div class="head position-sticky fixed-top mb-2 mt-2">
              <span>HAEMATOLOGY CLINIC</span>
            </div>
          </div>
          <div
            class="col-sm-12 col-md-4 col-lg-2 overflow-auto"
            style="max-height: 600px"
          >
            <div class="head position-sticky fixed-top mb-2 mt-2">
              <span>HORMONAL</span>
            </div>
            <div class="form-check">
              <input
                class="form-check-input"
                type="checkbox"
                value=""
                name="seventeen"
                id="seventeen"
              />
              <label class="form-check-label" for="seventeen"
                >17Ketosteroid(DHEAS)</label
              >
            </div>
            <div class="form-check">
              <input
                class="form-check-input"
                type="checkbox"
                value=""
                name="beta_hcg_quantitative"
                id="beta_hcg_quantitative"
              />
              <label class="form-check-label" for="beta_hcg_quantitative"
                >B-HCG Qantitative</label
              >
            </div>
            <div class="form-check">
              <input
                class="form-check-input"
                type="checkbox"
                value=""
                name="cortisol_serum"
                id="cortisol_serum"
              />
              <label class="form-check-label" for="cortisol_serum"
                >Cortisol Serum</label
              >
            </div>
            <div class="form-check">
              <input
                class="form-check-input"
                type="checkbox"
                value=""
                name="follicle_stimulating"
                id="follicle_stimulating"
              />
              <label class="form-check-label" for="follicle_stimulating"
                >Follicle Stimulating</label
              >
            </div>
            <div class="form-check">
              <input
                class="form-check-input"
                type="checkbox"
                value=""
                name="free_psa"
                id="free_psa"
              />
              <label class="form-check-label" for="free_psa">Free PSA</label>
            </div>
            <div class="form-check">
              <input
                class="form-check-input"
                type="checkbox"
                value=""
                name="free_thiroxine_ft4"
                id="free_thiroxine_ft4"
              />
              <label class="form-check-label" for="free_thiroxine_ft4"
                >Free Thyroxine(FT4)</label
              >
            </div>
            <div class="form-check">
              <input
                class="form-check-input"
                type="checkbox"
                value=""
                name="free_triiodothyronine"
                id="free_triiodothyronine"
              />
              <label class="form-check-label" for="free_triiodothyronine"
                >Free Triiodothyronine</label
              >
            </div>
            <div class="form-check">
              <input
                class="form-check-input"
                type="checkbox"
                value=""
                name="growth_hormone"
                id="growth_hormone"
              />
              <label class="form-check-label" for="growth_hormone"
                >Growth Hormone(GH)</label
              >
            </div>
            <div class="form-check">
              <input
                class="form-check-input"
                type="checkbox"
                value=""
                name="insulin"
                id="insulin"
              />
              <label class="form-check-label" for="insulin">Insulin</label>
            </div>
            <div class="form-check">
              <input
                class="form-check-input"
                type="checkbox"
                value=""
                name="luteinizing_hormone"
                id="luteinizing_hormone"
              />
              <label class="form-check-label" for="luteinizing_hormone"
                >Luteinizing Hormone(LH)</label
              >
            </div>
            <div class="form-check">
              <input
                class="form-check-input"
                type="checkbox"
                value=""
                name="oestradiol"
                id="oestradiol"
              />
              <label class="form-check-label" for="oestradiol"
                >Oestradiol (E2)</label
              >
            </div>
            <div class="form-check">
              <input
                class="form-check-input"
                type="checkbox"
                value=""
                name="oestriol"
                id="oestriol"
              />
              <label class="form-check-label" for="oestriol">Oestriol</label>
            </div>
            <div class="form-check">
              <input
                class="form-check-input"
                type="checkbox"
                value=""
                name="psa"
                id="psa"
              />
              <label class="form-check-label" for="psa">PSA</label>
            </div>
            <div class="form-check">
              <input
                class="form-check-input"
                type="checkbox"
                value=""
                name="progesterone"
                id="progesterone"
              />
              <label class="form-check-label" for="progesterone"
                >Progesterone</label
              >
            </div>
            <div class="form-check">
              <input
                class="form-check-input"
                type="checkbox"
                value=""
                name="prolactine"
                id="prolactine"
              />
              <label class="form-check-label" for="prolactine"
                >Prolactine (F)</label
              >
            </div>
            <div class="form-check">
              <input
                class="form-check-input"
                type="checkbox"
                value=""
                name="prolactine"
                id="prolactine"
              />
              <label class="form-check-label" for="prolactine"
                >Prolactine (M)</label
              >
            </div>
            <div class="form-check">
              <input
                class="form-check-input"
                type="checkbox"
                value=""
                name="steroid_hormone"
                id="steroid_hormone"
              />
              <label class="form-check-label" for="steroid_hormone"
                >STEROID HORMONE</label
              >
            </div>
            <div class="form-check">
              <input
                class="form-check-input"
                type="checkbox"
                value=""
                name="thyroid_hormones"
                id="thyroid_hormones"
              />
              <label class="form-check-label" for="thyroid_hormones"
                >THYROID HORMONES</label
              >
            </div>
            <div class="form-check">
              <input
                class="form-check-input"
                type="checkbox"
                value=""
                name="testosterone"
                id="testosterone"
              />
              <label class="form-check-label" for="testosterone"
                >Testosterone</label
              >
            </div>
            <div class="form-check">
              <input
                class="form-check-input"
                type="checkbox"
                value=""
                name="thyroid_stimulating"
                id="thyroid_stimulating"
              />
              <label class="form-check-label" for="thyroid_stimulating"
                >Thyroid Stimulating</label
              >
            </div>
            <div class="form-check">
              <input
                class="form-check-input"
                type="checkbox"
                value=""
                name="thyroxine"
                id="thyroxine"
              />
              <label class="form-check-label" for="thyroxine"
                >Thyroxine(T4)</label
              >
            </div>
            <div class="form-check">
              <input
                class="form-check-input"
                type="checkbox"
                value=""
                name="triiodothyronine"
                id="triiodothyronine"
              />
              <label class="form-check-label" for="triiodothyronine"
                >Triiodothyronine(T3)</label
              >
            </div>
          </div>
          <div class="col-sm-12 col-md-4 col-lg-2">
            <div class="head mb-2 mt-2">
              <span>MICROBIOLOGY</span>
            </div>
            <div class="form-check">
              <input
                class="form-check-input"
                type="checkbox"
                value=""
                name="stool_analysis"
                id="stool_analysis"
              />
              <label class="form-check-label" for="stool_analysis"
                >Stool Analysis</label
              >
            </div>
            <div class="form-check">
              <input
                class="form-check-input"
                type="checkbox"
                value=""
                name="urinalysis"
                id="urinalysis"
              />
              <label class="form-check-label" for="urinalysis"
                >Urinalysis</label
              >
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "lab-work",
  components: {},
  data() {
    return {
      drugs: {
        bodyFluids: [
          { name: "AFB", status: false },
          { name: "Albumin 1", status: false },
          { name: "Amylase/Lipase/TGL/LDH", status: false },
          { name: "CS", status: false },
          { name: "Cell Count", status: false },
          { name: "Cytologie", status: false },
          { name: "Diff", status: false },
          { name: "Glucose", status: false },
          { name: "Gram Stain", status: false },
          { name: "PH", status: false },
          { name: "Protein", status: false },
          { name: "Specific Gravity", status: false },
        ],
        drugAlcohol: [
          { name: "Alcohol", status: false },
          { name: "Amphetamine", status: false },
          { name: "Barbiturates", status: false },
          { name: "Cocaine (Benzoylecgonine)", status: false },
          { name: "Mandrax", status: false },
          { name: "Mathamphetamine", status: false },
          { name: "Methadone", status: false },
          { name: "Opiates (Morphine)", status: false },
          { name: "PCP", status: false },
          { name: "THZ (Marijuana)", status: false },
        ],
      },
    };
  },
};
</script>

<style scoped>
h4 {
  text-align: center;
}
span {
  font-weight: bold;
  color: #fff;
  padding: 2px;
}
.head {
  background-color: rgba(0, 0, 0, 0.4);
}
</style>