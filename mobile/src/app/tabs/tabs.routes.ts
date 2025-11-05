import { Routes } from '@angular/router';
import { TabsPage } from './tabs.page';

export const routes: Routes = [
  {
    path: 'tabs',
    component: TabsPage,
    children: [
      {
        path: 'matches',
        loadComponent: () =>
          import('../pages/matches/matches.page').then((m) => m.MatchesPage),
      },
      {
        path: 'report-result',
        loadComponent: () =>
          import('../pages/report-result/report-result.page').then((m) => m.ReportResultPage),
      },
      {
        path: 'camera',
        loadComponent: () =>
          import('../pages/camera/camera.page').then((m) => m.CameraPage),
      },
      {
        path: '',
        redirectTo: '/tabs/tab1',
        pathMatch: 'full',
      },
    ],
  },
  {
    path: '',
    redirectTo: '/tabs/matches',
    pathMatch: 'full',
  },
];
