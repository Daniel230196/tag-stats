import {ApolloServer} from "apollo-server-express";
import {ExpressContext} from "apollo-server-express";
import { buildSchema } from 'type-graphql';
import Express from 'express';
import {TagResolver} from "./tag/TagResolver";
import dns from "node:dns";
import bodyParser from "body-parser";


dns.setDefaultResultOrder('ipv4first');
const main = async () => {
    const schema =  await buildSchema({
        resolvers: [TagResolver],
        validate: false,
    })

// The rootValue provides a resolver function for each API endpoint
    const apolloServer = new ApolloServer({
        schema,
        context: ({ req, res }: ExpressContext) => ({
            req,
            res,
        }),
        debug: true
    });

    await apolloServer.start();
    const app = Express();
    app.use(bodyParser.urlencoded({ extended: false }));
    app.use(bodyParser.json());

    apolloServer.applyMiddleware({app, cors: false})

    app.listen(3000, () => {
        console.log('server started on http://localhost:3000/graphql');
    });
}

main().catch((error) => console.error(`${error.message} ${error.stack.split('\n')[1]}`));

