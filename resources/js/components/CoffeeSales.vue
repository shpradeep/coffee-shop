<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 card-wid">
                <div class="card">
                    <div class="card-header">
                        <div class="input-group">        
                            <div v-bind:class="'col-md-3 mb-3 sales-tag'">
                                <label for="product-options">Product</label>
                                <select class="form-select" id="product-options" @change="onChangeProduct($event)" v-model="product_id" aria-label="Disabled select example">
                                    <option class="form-control" v-for="item in products" :key="item.id" v-bind:value="item.id">{{item.product_name}}</option>
                                </select>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div v-bind:class="'col-md-2 mb-3 sales-tag'">
                                <label for="validationCustom01">Quantity</label>
                                <input type="text" v-model="items.sale_quantity" class="form-control border border-dark" id="validationCustom01" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div v-bind:class="'col-md-2 mb-3 sales-tag'">
                                <label for="validationCustom02">Unit Cost (£)</label>
                                <input type="text" v-model="items.per_unit_cost" class="form-control border border-dark" id="validationCustom02" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div v-bind:class="'col-md-3 mb-3 sales-tag'">
                                <label for="validationCustom03">Selling Price</label>

                                <span id="validationCustom03" v-bind:class="span_selling_price">{{ selling_price }}</span>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div v-bind:class="'col-md-3 mb-3 sales-tag'">
                                <label for="right-panel-link"></label>
                                <button id="right-panel-link" class="btn btn-primary" @click="save">Record Sale</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="sales_records.length > 0">
                    <h2 class="heading">Previous Sales</h2>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Quantity</th>
                                <th scope="col">Unit Cost</th>
                                <th scope="col">Selling Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in sales_records" v-bind:key="item.id">
                                <td>{{item.quantity}} </td>
                                <td>£{{item.unit_cost}}</td>
                                <td>£{{item.record_sale}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    name: 'CoffeeSales',
    data() {
        return {
            products: {},
            span_selling_price: '',
            sales_records: {},
            product_id: 1,
            product_details: {
                margin: '',
                shipping_cost: ''
            },
            items: {
                sale_quantity: '',
                per_unit_cost: '',
                selling_record: ''
            }
        }
    },
    mounted() {
        this.fetchAll();
        this.getProducts();
        this.getProductDetails();
    },
    methods: {
        onChangeProduct() {
            this.items.sale_quantity = '';
            this.items.per_unit_cost = '';
            this.items.selling_record = '';

            this.getProductDetails();
            this.fetchAll();
        },
        getProducts() {
            axios.get(`products`)
                .then((res) => {
                    this.products = res.data;
                });
        },
        getProductDetails() {
            axios.get(`product/${this.product_id}`)
                .then((res) => {
                    this.product_details.margin = res.data.profile_margin_in_percentage / 100;
                    this.product_details.shipping_cost = res.data.shipping_cost;
                });
        },
        fetchAll() {
            axios.get(`api/sales_records/${this.product_id}`)
                .then(res => this.sales_records = res.data)
        },
        save() {
            try {
                if (this.items.selling_record > 0) {
                    const myInput = {
                        'quantity': this.items.sale_quantity,
                        'product_id': this.product_id,
                        'unit_cost': this.items.per_unit_cost,
                        'record_sale': this.items.selling_record,
                    }
                    axios.post('api/sales_records', myInput)
                        .then((res) => {
                            alert(res.data.message);
                            this.items.sale_quantity = '';
                            this.items.per_unit_cost = '';
                            this.items.selling_record = '';
                            this.fetchAll()
                        });
                } else {
                    alert('Please provide valid input');
                }
            } catch(e) {
                console.log(e);
            }
        }
    },
    computed: {
        selling_price() {
            if (Number(this.items.sale_quantity) > 0 && Number(this.items.per_unit_cost) > 0) {
                if (this.product_details.margin == '' || this.product_details.shipping_cost == '') {
                    alert('OOPs, Something went wrong!');
                }
                let total_cost = this.items.sale_quantity * this.items.per_unit_cost;
                let profile_margin = (1 - this.product_details.margin);
                let cost_without_shipping = (total_cost / profile_margin);

                this.items.selling_record = cost_without_shipping + Number(this.product_details.shipping_cost);
                this.items.selling_record = parseFloat(this.items.selling_record).toFixed(2);
                this.span_selling_price = 'form-control';
                return this.items.selling_record > 0 ? '£' + this.items.selling_record : '';
            } else {
                this.span_selling_price = '';
            }
        }
  }
}

</script>

<style scoped>
    #right-panel-link {
        position: absolute;
        top: 23px;
        right: 0;
    }

    .sales-tag {
        padding-left: 15px;
        padding-right: 15px;
    }

    input.form-control {
        -webkit-appearance: none;
        -webkit-border-radius: 0px;
    }

    .heading {
        padding-top: 20px;
        padding-bottom: 5px;
    }

    .card-wid {
        width: 80%;
    }

    .form-select {
        outline: none !important;
        box-shadow: none !important;
    }
</style>