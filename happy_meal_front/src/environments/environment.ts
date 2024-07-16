export const environment = {
  production: true,
  cli: true,
  environmentName: 'prod',

  urls: {
    orderBrokerBaseUrl: process.env.ORDER_BROKER_BASE_URL,
    orders: {
      getOrders: 'kitchen/orders',
      getOrderById: 'kitchen/orders/:id',
      makeOrder: 'kitchen/orders',
    },
    dish: {
      getDishes: 'kitchen/menu',
    },
    stock: {
      getPurchaseHistory: 'stock/purchases',
      getIngredients: 'stock/ingredients',
    },
  },
};
