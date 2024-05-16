let routes= [];

import dashboard from "./vue-routes-dashboard";
import company from "./vue-routes-companies";
import contact from "./vue-routes-contacts";

routes = routes.concat(dashboard);
routes = routes.concat(company);
routes = routes.concat(contact);

export default routes;
