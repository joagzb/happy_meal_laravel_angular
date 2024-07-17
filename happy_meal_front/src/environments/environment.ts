export const environment = {
  production: true,
  cli: false,
  environmentName: 'prod',

  urls: {
    orderBrokerBaseUrl: 'https://msorderhandler-production.up.railway.app',
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
