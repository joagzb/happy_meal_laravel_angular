import {ApplicationConfig, provideZoneChangeDetection} from '@angular/core';
import {provideRouter} from '@angular/router';

import {routes} from './app.routes';
import {provideAnimationsAsync} from '@angular/platform-browser/animations/async';
import {errorInterceptor} from './interceptors/error-interceptor.interceptor.js';
import {generalInterceptor} from './interceptors/general-interceptor.interceptor.js';
import {provideHttpClient, withInterceptors} from '@angular/common/http';

export const appConfig: ApplicationConfig = {
  providers: [provideZoneChangeDetection({eventCoalescing: true}), provideRouter(routes), provideAnimationsAsync(), provideHttpClient(withInterceptors([errorInterceptor, generalInterceptor])),],
};
