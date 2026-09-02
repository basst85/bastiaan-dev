---
title: "Building a durable agent harness: workflow orchestration with Eve"
published: true
publish_date: 2026-09-02 21:00
updated_date: 2026-09-02 21:00
author: Bastiaan
intro: "A while loop calling an LLM is easy to prototype and hard to run in production. Eve moves state management, subagent routing, and human approval gates into a durable harness instead."
tags: development,ai,llm,agentic orchestration,workflow
min_read: 5
header_image: /images/durable-agent-harness-eve.jpg
---
<div class="max-w-sm md:max-w-full">

## Introduction

Building an AI agent prototype is trivial today. You write a while loop. It takes a prompt, calls the LLM API, triggers a tool, appends the JSON response, and loops until the model stops asking for tools. Oracle's recent engineering blog defines this as a "Level 1" agent. It works perfectly on a local machine for a three minutes demo.

Deploying that same code to production breaks quickly. Long-horizon tasks require persistent state because a single context window is not infinite memory. When an agent loses track of what it has already tried, it will invoke the exact same tool repeatedly. Developers usually try to fix this infinite looping by hardcoding an arbitrary limit, like `max_iterations = 10`. If the container times out before the task finishes, the entire session drops out of memory.

The problem is architectural. We are treating large language models as stateful applications when they are just inference engines. The surrounding infrastructure, the "harness", needs to manage the state.

This is also where the squad-of-subagents approach described in [Building a parallel development squad: agentic orchestration with Claude](https://bastiaan.dev/blog/agentic-orchestration-claude) runs into the same wall: routing work across specialized agents solves the confusion problem, but without a durable harness underneath it, the orchestration still lives and dies with a single process.

## File-based routing instead of one giant system prompt

[Eve](https://eve.dev) tackles this by enforcing a file-based routing system, similar to how Next.js structures web applications. Shoving every available tool into a single system prompt degrades performance. Eve isolates capabilities into specific subagents in dedicated directories.

```text
my-agent/
├── agent.ts
├── channels/
│   └── slack.ts
└── subagents/
    ├── researcher/
    │   └── tools/
    │       └── query_vector_db.ts
    └── engineer/
        ├── instructions.md
        └── sandbox/
            └── sandbox.ts

```

The Lead Agent acts purely as a router. It delegates discrete tasks to subagents like the `researcher` or `engineer`. Each subagent operates within its own restricted Docker sandbox. The harness handles the state transitions between them, keeping the context window lean and preventing the LLM from getting confused by irrelevant tools.

## Human approval gates without holding a request open

This architecture also solves deployment roadblocks, specifically human approval gates. An agent generating a database migration script needs human review before execution. In a basic Python loop, waiting for an approval click means holding an HTTP request open until it inevitably times out.

[Eve](https://eve.dev) checkpoints every execution step to a Postgres database. It runs as a durable workflow. When the subagent reaches a destructive action, it parks the state and sends a notification to a Slack channel. The workflow exits memory completely. Hours later, when an engineer approves the request, Eve pulls the state from the database and resumes execution right where it left off.

## Conclusion

Rethinking the agent loop means moving the complexity into the harness. Frameworks like [Eve](https://eve.dev) provide the structure needed to run asynchronous, durable agent workflows without the operational overhead.

</div>
