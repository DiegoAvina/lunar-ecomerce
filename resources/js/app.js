import Alpine from 'alpinejs';

window.Alpine = Alpine;


// ============================================================
// SWIPER
// ============================================================

import Swiper from 'swiper';

import {
    Navigation,
    Pagination,
    Autoplay
} from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

window.Swiper = Swiper;

window.SwiperModules = {
    Navigation,
    Pagination,
    Autoplay,
};


// ============================================================
// CART WIDGET
// ============================================================

window.cartWidget = function () {

    return {

        dataUrl: null,

        quantity: 0,

        items: [],

        subtotal: '$0.00',

        tax: '$0.00',

        shipping: '$0.00',

        total: '$0.00',

        open: false,

        loading: false,


        init(dataUrl) {

            this.dataUrl = dataUrl;

            console.log(
                'CART INIT:',
                this.dataUrl
            );

            this.refresh();

            window.addEventListener(
                'cart-updated',
                () => {
                    this.refresh();
                }
            );
        },


        async refresh() {

            if (!this.dataUrl) {

                console.error(
                    'CART WIDGET: No se recibió la URL del carrito.'
                );

                return;
            }


            try {

                console.log(
                    'CONSULTANDO CARRITO:',
                    this.dataUrl
                );


                const response = await fetch(
                    this.dataUrl,
                    {
                        method: 'GET',

                        headers: {
                            'Accept': 'application/json'
                        },

                        credentials: 'same-origin',

                        cache: 'no-store'
                    }
                );


                const contentType =
                    response.headers.get('content-type') || '';


                if (!response.ok) {

                    const text = await response.text();

                    console.error(
                        'RESPUESTA ERROR CART:',
                        text
                    );

                    throw new Error(
                        `Error HTTP ${response.status}`
                    );
                }


                if (!contentType.includes('application/json')) {

                    throw new Error(
                        'El servidor no devolvió JSON.'
                    );
                }


                const data =
                    await response.json();


                console.log(
                    'RESPUESTA CART:',
                    data
                );


                if (
                    !data.success ||
                    !data.cart
                ) {

                    throw new Error(
                        'Respuesta inválida del carrito.'
                    );
                }


                this.applyCart(
                    data.cart
                );


            } catch (error) {

                console.error(
                    'ERROR CART WIDGET:',
                    error
                );

            }

        },


        applyCart(cart) {

            this.quantity =
                Number(
                    cart?.quantity ?? 0
                );


            this.items =
                Array.isArray(cart?.items)
                    ? cart.items
                    : [];


            this.subtotal =
                cart?.subtotal ?? '$0.00';


            this.tax =
                cart?.tax ?? '$0.00';


            this.shipping =
                cart?.shipping ?? '$0.00';


            this.total =
                cart?.total ?? '$0.00';


            console.log(
                'CART STATE:',
                {
                    quantity: this.quantity,
                    items: this.items
                }
            );
        },


        async updateItem(
            lineId,
            quantity
        ) {

            if (this.loading) {
                return;
            }


            this.loading = true;


            try {

                const response = await fetch(
                    `/carrito/items/${lineId}`,
                    {
                        method: 'PATCH',

                        headers: {
                            'Content-Type':
                                'application/json',

                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                document.querySelector(
                                    'meta[name="csrf-token"]'
                                )?.content || ''
                        },

                        credentials: 'same-origin',

                        body: JSON.stringify({
                            quantity: quantity
                        })
                    }
                );


                const contentType =
                    response.headers.get('content-type') || '';


                const data =
                    contentType.includes('application/json')
                        ? await response.json()
                        : null;


                if (!response.ok) {

                    throw new Error(
                        data?.message ||
                        'No se pudo actualizar el producto.'
                    );
                }


                if (!data?.success) {

                    throw new Error(
                        data?.message ||
                        'No se pudo actualizar el producto.'
                    );
                }


                this.applyCart(
                    data.cart
                );


                window.dispatchEvent(
                    new CustomEvent(
                        'cart-updated',
                        {
                            detail: data.cart
                        }
                    )
                );


            } catch (error) {

                console.error(
                    'Error actualizando cantidad:',
                    error
                );

                alert(
                    error.message ||
                    'No se pudo actualizar la cantidad.'
                );


            } finally {

                this.loading = false;

            }
        },


        async removeItem(lineId) {

            if (this.loading) {
                return;
            }


            this.loading = true;


            try {

                const response = await fetch(
                    `/carrito/items/${lineId}`,
                    {
                        method: 'DELETE',

                        headers: {
                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                document.querySelector(
                                    'meta[name="csrf-token"]'
                                )?.content || ''
                        },

                        credentials: 'same-origin'
                    }
                );


                const contentType =
                    response.headers.get('content-type') || '';


                const data =
                    contentType.includes('application/json')
                        ? await response.json()
                        : null;


                if (!response.ok) {

                    throw new Error(
                        data?.message ||
                        'No se pudo eliminar el producto.'
                    );
                }


                if (!data?.success) {

                    throw new Error(
                        data?.message ||
                        'No se pudo eliminar el producto.'
                    );
                }


                this.applyCart(
                    data.cart
                );


                window.dispatchEvent(
                    new CustomEvent(
                        'cart-updated',
                        {
                            detail: data.cart
                        }
                    )
                );


            } catch (error) {

                console.error(
                    'Error eliminando producto:',
                    error
                );

                alert(
                    error.message ||
                    'No se pudo eliminar el producto.'
                );


            } finally {

                this.loading = false;

            }
        },


        async clearCart() {

            if (this.loading) {
                return;
            }


            if (this.items.length === 0) {
                return;
            }


            if (
                !confirm(
                    '¿Seguro que quieres vaciar el carrito?'
                )
            ) {
                return;
            }


            this.loading = true;


            try {

                const response = await fetch(
                    `/carrito`,
                    {
                        method: 'DELETE',

                        headers: {
                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                document.querySelector(
                                    'meta[name="csrf-token"]'
                                )?.content || ''
                        },

                        credentials: 'same-origin'
                    }
                );


                const contentType =
                    response.headers.get('content-type') || '';


                const data =
                    contentType.includes('application/json')
                        ? await response.json()
                        : null;


                if (!response.ok) {

                    throw new Error(
                        data?.message ||
                        'No se pudo vaciar el carrito.'
                    );
                }


                if (!data?.success) {

                    throw new Error(
                        data?.message ||
                        'No se pudo vaciar el carrito.'
                    );
                }


                this.applyCart(
                    data.cart
                );


                window.dispatchEvent(
                    new CustomEvent(
                        'cart-updated',
                        {
                            detail: data.cart
                        }
                    )
                );


            } catch (error) {

                console.error(
                    'Error vaciando carrito:',
                    error
                );

                alert(
                    error.message ||
                    'No se pudo vaciar el carrito.'
                );


            } finally {

                this.loading = false;

            }
        }

    };

};


// ============================================================
// AGREGAR AL CARRITO (cards de producto)
// ============================================================

window.addToCartButton = function (url, variantId, quantity = 1) {

    return {

        loading: false,

        added: false,

        variantId: variantId,


        async add() {

            if (this.loading || !this.variantId) {
                return;
            }

            this.loading = true;


            try {

                const response = await fetch(
                    url,
                    {
                        method: 'POST',

                        headers: {
                            'Content-Type': 'application/json',

                            'Accept': 'application/json',

                            'X-CSRF-TOKEN':
                                document.querySelector(
                                    'meta[name="csrf-token"]'
                                )?.content || ''
                        },

                        credentials: 'same-origin',

                        body: JSON.stringify({
                            variant_id: this.variantId,
                            quantity: quantity
                        })
                    }
                );


                const contentType =
                    response.headers.get('content-type') || '';

                const data =
                    contentType.includes('application/json')
                        ? await response.json()
                        : null;


                if (!response.ok || !data?.success) {

                    throw new Error(
                        data?.message ||
                        'No se pudo agregar el producto al carrito.'
                    );
                }


                this.added = true;

                window.dispatchEvent(
                    new CustomEvent(
                        'cart-updated',
                        {
                            detail: data.cart
                        }
                    )
                );

                setTimeout(() => {
                    this.added = false;
                }, 2000);


            } catch (error) {

                console.error(
                    'Error agregando al carrito:',
                    error
                );

                alert(
                    error.message ||
                    'No se pudo agregar el producto al carrito.'
                );

            } finally {

                this.loading = false;

            }
        }

    };

};


// ============================================================
// ALPINE
// ============================================================

Alpine.start();