<template>
	<div>
		<h5 class="text-semibold">RUMUS</h5>

		<!-- katex1 -->
		<div v-for="katex in modalKatex.katex1" v-if="katex.content">
			<p v-if="katex.title"><b>Keterangan:</b> {{katex.title}}</p>
			<div class="card ">
				<div class="card-body text-center pre-scrollable">
					<div v-katex="katex.content"></div>
				</div>
			</div>
		</div>
 
		<!-- indikator -->
		<div class="alert bg-info alert-styled-left mt-2 pt-1 pb-1">
			<span class="mb-5 text-semibold"><u>Indikator:</u></span>
			<p v-html="modalKatex.indikator"></p>
		</div>
		
		<!-- separator	 -->
		<hr>

		<h5 class="text-semibold">PERHITUNGAN <small>{{ modalKatex.section }}</small></h5>

		<!-- katex2 -->
		<div v-for="katex in modalKatex.katex2" v-if="katex.content">
			<p v-if="katex.title"><b>Keterangan:</b> {{katex.title}}</p>
			<div class="well mb-2 pre-scrollable text-center">
				<div v-katex="katex.content"></div>
			</div>
		</div>

		<!-- ubah -->
		<form @submit.prevent="save" data-vv-scope="form">
		<hr v-if="modalKatex.isUbah && currentUser.can && currentUser.can['update_laporan_cu']">
		<div class="row" v-if="modalKatex.isUbah && currentUser.can && currentUser.can['update_laporan_cu']">
				<div class="col-sm-6" v-if="!form.hideForm && form.title" v-for="form in modalKatex.form">
					<div class="form-group">

						<!-- title -->
						<h5>{{form.title}}:</h5>

						<!-- value -->
						<cleave 
							v-model="form.value" 
							class="form-control" 
							:options="cleaveOption.numeric"
							:placeholder="'Silahkan masukkan ' + form.title"></cleave>
					</div>
				</div>

		</div>
		
		<hr>
		<div class="text-center d-none d-md-block">
			<button type="button" @click.prevent="modalTutup" class="btn btn-light">
				<i class="icon-cross"></i> Tutup
			</button>
			<button type="button" @click.prevent="modalKatex.isUbah = true" class="btn btn-light" v-if="!modalKatex.isUbah && currentUser.can && currentUser.can['update_laporan_cu']">
				<i class="icon-pencil5"></i> Ubah
			</button>

			<button type="button" @click.prevent="modalKatex.isUbah = false" class="btn btn-light" v-if="modalKatex.isUbah && currentUser.can && currentUser.can['update_laporan_cu']">
				<i class="icon-arrow-left13"></i> Batal
			</button>
			<button type="submit" class="btn btn-primary" v-if="modalKatex.isUbah">
				<i class="icon-floppy-disk"></i> Simpan
			</button>
		</div>

		<div class="d-block d-md-none">

			<button type="submit" class="btn btn-primary btn-block" v-if="modalKatex.isUbah && currentUser.can && currentUser.can['update_laporan_cu']">
				<i class="icon-floppy-disk"></i> Simpan
			</button>

			<button type="button" @click.prevent="modalKatex.isUbah = false" class="btn btn-light btn-block" v-if="modalKatex.isUbah && currentUser.can && currentUser.can['update_laporan_cu']">
				<i class="icon-arrow-left13"></i> Batal
			</button>

			<button type="button" @click.prevent="modalKatex.isUbah = true" class="btn btn-light btn-block" v-if="!modalKatex.isUbah && currentUser.can && currentUser.can['update_laporan_cu']">
				<i class="icon-pencil5"></i> Ubah
			</button>

			<button type="button" @click.prevent="modalTutup" class="btn btn-light btn-block">
				<i class="icon-cross"></i> Tutup
			</button>
			
		</div>

		</form>
	</div>
</template>

<script>
	import { mapGetters } from 'vuex';
	import Cleave from 'vue-cleave-component';

	export default {
		components:{
			Cleave
		},
		props:['modalKatex','kelas'],
		data() {
			return {
				cleaveOption: {
          numeric: {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            numeralDecimalScale: 2,
            numeralDecimalMark: ',',
            delimiter: '.'
          }
				},
				form: {}
			}
		},
		created(){
		},
		methods: {
			save(){
				this.form = _.chain(this.modalKatex.form).keyBy('key').mapValues('value').value();
				this.form.periode = this.modalKatex.periode;
				
				if(this.modalKatex.id_tp){
					this.form.id_tp = this.modalKatex.id_tp;
					this.form.no_tp = this.modalKatex.no_tp;
					this.form.id_cu = this.modalKatex.id_cu;
					this.form.no_ba = this.modalKatex.no_ba;

					this.$store.dispatch('laporanTp/update', [this.modalKatex.id,this.form]);
				}else{
					this.form.id_cu = this.modalKatex.id_cu;
					this.form.no_ba = this.modalKatex.no_ba;

					this.$store.dispatch('laporanCu/update', [this.modalKatex.id,this.form]);
				}
				
			},
			modalTutup(){
				this.$emit('tutup');
			},
			formatPeriode(value){
				return Vue.filter('dateMonth')(value);
			},
			formatCurrency(value){
				return this.$options.filters.currency(value,'',0,{ thousandsSeparator: '.'});
			},
			formatPercentage(value){
				return Vue.filter('percentage2')(value,2);
			}
		},
		computed: {
			...mapGetters('auth',{
				currentUser: 'currentUser'
			})
		}
	}
</script>