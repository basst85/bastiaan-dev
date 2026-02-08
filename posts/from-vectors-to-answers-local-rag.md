---
title: "From Vectors to Answers: Building a Local RAG Agent"
published: true
publish_date: 2026-02-08 21:00
updated_date: 2026-02-08 21:00
author: Bastiaan
intro: "Semantic search finds the right text. RAG turns that text into grounded answers. In this post we’ll build a local RAG agent with Bun, SQLite vector search, and Ollama. Fast, private, and simple."
tags: development,vector search,sqlite,llm,rag,ollama,sqlite,bun,artificial-intelligence
min_read: 12
header_image: /images/local-rag-agent.jpg
---
<div class="max-w-sm md:max-w-full">

## Introduction

In my previous post, I showed how semantic search works by turning text into vectors and comparing those vectors to find meaningfully similar content:
[https://bastiaan.dev/blog/from-text-to-vectors](https://bastiaan.dev/blog/from-text-to-vectors)

That pipeline gets you *results*.

But most of the time, you don’t want results.

You want an answer.

And you want that answer to be grounded in **your** knowledge base: docs, policies, manuals, product specs, runbooks, ticket history — whatever your users actually care about.

That’s where **RAG (Retrieval‑Augmented Generation)** comes in.

## Where this is useful (real examples)

RAG + vector search is one of those techniques that scales from tiny side project to serious production system.

A few practical examples:

- **Customer support / helpdesk chatbots** that answer questions using your internal knowledge base (refund policy, troubleshooting steps, warranty rules).
- **Internal assistants** for engineers (searching runbooks, ADRs, onboarding docs, architecture docs).
- **Product search and recommendations** that work even when people don’t type the “right” keywords.
- **Document Q&A** (PDFs, meeting notes, release notes) where you want answers that cite the source text.
- **Compliance and policy assistants** that reduce “confidently wrong” replies by retrieving the exact policy chunk first.

The common pattern: you want the model to answer **with context**, not just vibes.

## A practical mental model for RAG

Retrieval-Augmented Generation (RAG) is a way to make AI language models smarter, more accurate, and more up-to-date by letting them look things up before they answer.

RAG is basically semantic search plus one extra step.

A typical RAG pipeline looks like this:

1. **Embed** your documents into vectors.
2. **Store** those vectors in a database.
3. When the user asks a question: **embed** the question too.
4. **Retrieve** the most similar vectors (top‑k).
5. **Generate** an answer using the retrieved text as context.

So: **search first, answer second**.

## Why build RAG locally?

Cloud RAG stacks are great, but local RAG has some strong advantages:

- **Privacy**: your knowledge base stays on your machine.
- **Speed**: no network hops for embeddings or retrieval.
- **Simplicity**: a single SQLite file is hard to beat.
- **Portability**: you can ship the database with your app.

The sweet spot is when your data is sensitive, your latency budget is tight, or you want a minimal stack that still feels “real”.

## The building blocks

For this post, we’ll look at a small demo project that ties the full loop together:

**local-ollama-rag-agent**
[https://github.com/basst85/local-ollama-rag-agent](https://github.com/basst85/local-ollama-rag-agent)

It uses:

- **Ollama** for running models locally (embeddings + chat).
- **EmbeddingGemma** for embeddings (fast, on-device friendly).
- **Bun** as the runtime (TypeScript + a great SQLite driver).
- **SQLite** as the vector store.
- **sqlite-vector** as the vector search extension.

Let’s quickly unpack the interesting parts.

## Embeddings: why EmbeddingGemma is a nice fit

EmbeddingGemma is designed specifically for on-device retrieval use cases like RAG and semantic search.

The detail I like most is **flexible output dimensions** using Matryoshka Representation Learning (MRL). In practice that means you can trade off speed/storage vs quality by using a smaller slice of the embedding (for example 256 dims instead of 768).

- Smaller vectors → less disk, less RAM, faster similarity search.
- Still good retrieval performance for many practical workloads.

More here:
[https://developers.googleblog.com/en/introducing-embeddinggemma/](https://developers.googleblog.com/en/introducing-embeddinggemma/)

And the technical report:
[https://arxiv.org/html/2509.20354v3](https://arxiv.org/html/2509.20354v3)

## Vector search inside SQLite (yes, really)

If you’ve ever used SQLite, you know it’s a Swiss army knife.

The missing piece for modern AI apps is: **vector search**.

That’s what sqlite-vector provides:
[https://github.com/sqliteai/sqlite-vector](https://github.com/sqliteai/sqlite-vector)

It’s a SQLite extension that lets you store embeddings as BLOBs and run similarity search (cosine / dot / L2 depending on configuration).

This is a big deal because it means you can keep the entire knowledge base in a single file:

- no separate vector database server
- no extra infrastructure
- no “sidecar” process to run

## Bun + SQLite: a clean runtime for this stack

Bun ships with a SQLite driver (`bun:sqlite`) and supports loading extensions.

Docs:
[https://bun.com/docs/runtime/sqlite](https://bun.com/docs/runtime/sqlite)

That makes it a great fit for “local-first” AI tools:
TypeScript + SQLite + extensions + HTTP calls to Ollama.

## How the demo agent works (step-by-step)

The local-ollama-rag-agent README summarizes the flow in a clean way:

1. **Embed**: documents → vectors (EmbeddingGemma via Ollama)
2. **Store**: vectors in SQLite (sqlite-vector)
3. **Search**: vector similarity search returns top‑k chunks
4. **Answer**: an LLM answers using the retrieved context

One more detail makes it feel like an “agent” instead of a script:

### Tool-calling: retrieve only when needed

Not every question needs retrieval.

If someone asks “2 + 2”, retrieval adds noise.

So the project exposes a `search_database` tool and lets the chat model decide when to call it. This keeps answers clean and can reduce latency.

![Flowchart RAG](/images/from-vectors-to-answers-local-rag-flowchart.png)

## Conclusion

Semantic search helps you find the right text.

RAG turns that text into answers. And if you build it locally, you also get privacy and simplicity for free.

## References and further reading

<a href="https://bastiaan.dev/blog/from-text-to-vectors" target="_blank">From Text to Vectors: A Practical Guide to Semantic Search</a>

<a href="https://github.com/basst85/local-ollama-rag-agent" target="_blank">local-ollama-rag-agent (GitHub)</a>

<a href="https://developers.googleblog.com/en/introducing-embeddinggemma/" target="_blank">Introducing EmbeddingGemma (Google Developers Blog)</a>

<a href="https://arxiv.org/html/2509.20354v3" target="_blank">EmbeddingGemma technical report (arXiv)</a>

<a href="https://github.com/sqliteai/sqlite-vector" target="_blank">sqlite-vector (GitHub)</a>

<a href="https://bun.com/docs/runtime/sqlite" target="_blank">Bun SQLite runtime docs</a>

</div>
