let routes= [];

import dashboard from "./vue-routes-dashboard";
import company from "./vue-routes-companies";
import contact from "./vue-routes-contacts";
import product from "./vue-routes-products";

routes = routes.concat(dashboard);
routes = routes.concat(company);
routes = routes.concat(contact);
routes = routes.concat(product);

export default routes;
