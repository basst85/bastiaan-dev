---
title: "End-to-End Type Safety: Building with the BEDR-stack"
published: true
publish_date: 2026-05-20 20:30
updated_date: 2026-05-20 20:46
author: Bastiaan
intro: "Modern full-stack development doesn't require heavy meta-frameworks. In this post, we explore the BEDR-stack: Bun, Elysia, Drizzle, and React. A practical, type-safe monorepo setup."
tags: development,typescript,bun,elysia,drizzle,react,monorepo
min_read: 10
header_image: /images/bedr-stack.jpg
---
<div class="max-w-sm md:max-w-full">

## Introduction

Modern full-stack web application architecture is shifting. Instead of relying entirely on separated ecosystems, the focus is increasingly on tighter integrations. This post covers the [BEDR-stack](https://github.com/basst85/BEDR-stack). Its implementation is a practical approach to building monorepo applications. 

Let's look at the BEDR-stack from first principles, exactly as it is used in a typical monorepo setup.

## What is the BEDR-stack?

The [BEDR-stack](https://github.com/basst85/BEDR-stack) is a monorepo architecture built on four pillars: Bun, ElysiaJS, Drizzle ORM, and React 19.

- **Bun**: Serves as the core runtime and package manager. Its native APIs offer performance improvements for server-side processing and database interactions.
- **ElysiaJS**: A web framework optimized for Bun. It is built with type safety in mind.
- **Drizzle ORM**: The database layer. Within the stack, it interacts well with local SQLite databases.
- **React 19**: Powers the frontend via Vite, using modern client-side rendering features.

A core part of the stack is the shared Eden Treaty client. This allows the frontend to inherit the backend's types via a shared workspace (`packages/shared-client`). This removes the need for manual synchronization.

## What the BEDR-stack is not

This is not an enterprise framework that hides its inner workings behind multiple abstraction layers. The BEDR-stack is transparent. You maintain control, from the server configuration down to the Drizzle migration scripts.

It is also not an off-the-shelf system that dictates your entire architecture. It provides the core building blocks to structure your backend and frontend in a way that fits your specific application needs.

## Where BEDR is useful

By grouping the backend (API) and frontend in a single Bun workspace, you reduce network and development overhead. The frontend bundle remains focused on the UI, while server logic runs on the Bun runtime.

In a practical environment, this translates to less context-switching and more straightforward deployments. The [BEDR-stack](https://github.com/basst85/BEDR-stack) provides a solid foundation for modern web applications.

## The Normal Way vs. BEDR

Let's look at a typical feature: user management. In a traditional Node/Express setup, controllers often require manual verification to ensure the incoming payload matches the expected data structures.

Within the BEDR-stack, this is handled differently. First, we define our schema with Drizzle:

```typescript
// apps/backend/src/modules/users/model.ts
import { sqliteTable, text, integer } from 'drizzle-orm/sqlite-core';

export const users = sqliteTable('users', {
  id: integer('id').primaryKey({ autoIncrement: true }),
  name: text('name').notNull(),
  email: text('email').notNull().unique(),
});
```

Next, we build the Elysia controller. Here we define the logic and establish the type contract for the client:

```typescript
// apps/backend/src/modules/users/controller.ts
import { Elysia, t } from 'elysia';
import { db } from '../../db';
import { users } from './model';

export const usersController = new Elysia({ prefix: '/users' })
  .get('/', async () => {
    return await db.select().from(users);
  })
  .post('/', async ({ body }) => {
    // Insert logic omitted for brevity
    return { success: true, user: body.name };
  }, {
    body: t.Object({
      name: t.String(),
      email: t.String()
    })
  });
```

Elysia validates incoming data via `t.Object`. If a field is missing, TypeScript flags an error in the IDE thanks to Eden Treaty.

## Rendering with React 19 on the Client

Because the React frontend consumes data directly from the shared client, the codebase remains organized. There is no need to maintain custom `fetch` wrappers or external tools like Swagger clients. You import the client and get type completion across your API structure.

```typescript
// apps/frontend/src/pages/Users.tsx
import { useEffect, useState } from 'react';
import { client } from 'shared-client';

export const UsersPage = () => {
  const [users, setUsers] = useState([]);

  useEffect(() => {
    // Type-safety without manual DTOs
    client.api.users.get().then(({ data }) => {
      if (data) setUsers(data);
    });
  }, []);

  return (
    <div className="bg-[#0b0c10] text-[#66fcf1] p-8 min-h-screen">
      <h1 className="text-2xl font-bold mb-4 drop-shadow-[0_0_8px_rgba(102,252,241,0.5)]">
        System Users
      </h1>
      <ul>
        {users.map(u => <li key={u.id}>{u.name}</li>)}
      </ul>
    </div>
  );
};
```

## When to use BEDR

This stack isn't necessary for every project. If you are publishing a simple blog or a purely static website, a static-site generator is usually a better fit. 

However, for applications with custom logic, where you have a database, API endpoints, and a dynamic frontend, [BEDR-stack](https://github.com/basst85/BEDR-stack) offers a streamlined developer experience. The architectural flexibility combined with strict type safety makes it a practical setup.

## Conclusion

The BEDR-stack provides a cohesive workflow. Data management and routing are closely aligned with the frontend. By combining Bun and Elysia with the React ecosystem, it results in a development environment that simplifies building full-stack applications.

## References and further reading

<a href="https://github.com/basst85/BEDR-stack/" target="_blank">BEDR-stack (GitHub)</a>

<a href="https://bun.sh/" target="_blank">Bun Runtime</a>

<a href="https://elysiajs.com/" target="_blank">ElysiaJS</a>

<a href="https://orm.drizzle.team/" target="_blank">Drizzle ORM</a>

</div>
