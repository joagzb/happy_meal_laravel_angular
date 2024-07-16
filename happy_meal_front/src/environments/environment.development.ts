export const environment = {
  production: false,
  cli: true,
  environmentName: 'dev',

  urls: {
    frontendUrl: 'http://localhost:4200',
    orderBrokerBaseUrl: 'http://localhost:8000',
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
