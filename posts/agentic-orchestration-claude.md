---
title: "Building a parallel development squad: agentic orchestration with Claude"
published: true
publish_date: 2026-06-14 19:30
updated_date: 2026-06-14 20:00
author: Bastiaan
intro: "Single-prompt engineering is reaching its limits; it is time to replace the monolithic chatbot with a squad of specialized sub-agents. In this post, we explore how to build an autonomous development workflow using Claude, the Model Context Protocol (MCP), and local RAG."
tags: development,ai,llm,agentic orchestration,mcp,rag,workflow
min_read: 10
header_image: /images/agentic-orchestration.jpg
---
<div class="max-w-sm md:max-w-full">

## Introduction

We’ve all been there: you try to teach an LLM your exact team coding guidelines, your UI component interfaces, and your strict state management rules. You start with a meticulously crafted system prompt. It works beautifully for the first few prompts. Then, as the chat history grows, the context windows bloat, reasoning slows down, and the model suddenly forgets rule #4 and starts generating legacy React code.

This is a classic problem: monolithic prompt dilution. When you force a single LLM session to be a creative builder, a ruthless linter, and a security auditor all at once, its focus degrades.

The industry is moving away from the "all-knowing chatbot" paradigm. The new standard for enterprise-grade codebase intelligence is Agentic Orchestration—splitting a single monolithic session into a dynamic squad of specialized sub-agents guided by explicit workflows, decoupled through the Model Context Protocol (MCP), and backed by just-in-time knowledge retrieval.

Here is how to architect it.

## Moving RAG Behind the MCP Gateway

In a previous post, we explored how to parse local documentation and build a semantic search pipeline in [From Vectors to Answers: Local RAG](https://bastiaan.dev/blog/from-vectors-to-answers-local-rag). In that setup, a human developer queries a local vector database to find answers.

In an agentic architecture, we take that exact same local RAG pipeline and move it behind a **Model Context Protocol** (MCP) server.

![Agentic orchestration flow](/images/agentic-orchestration-flow.jpg)

Instead of stuffing your entire React component library documentation into the prompt upfront, the sub-agent is equipped with an MCP tool like `mcp__internal_knowledge__search_components`. 
When the sub-agent realizes it needs to build a datagrid, it queries the local RAG infrastructure just-in-time. 
It pulls only the precise TypeScript interfaces and styling rules needed for that exact file, keeping the context window incredibly clean and efficient.

## Configuring the Specialists

In modern agentic environments, defining a specialized sub-agent is as simple as dropping a Markdown file with YAML frontmatter into your project repository (e.g., under `.claude/agents/`). This frontmatter strictly dictates the agent's permissions and available tools.

Here is an example of a specialized frontend engineer teammate:

```markdown
---
name: UI Component Architect
description: Responsible for generating React components strictly adhering to the internal design system.
allowed_tools:
  - mcp__internal_knowledge__search_components
  - mcp__internal_knowledge__get_component_interface
file_access: read-write
---

You are the UI Component Architect. Your sole responsibility is to design and write React components.

**Execution Rules:**
1. Before writing any UI code, you MUST call `search_components` to verify if an internal atomic component already exists for this use-case.
2. Always output strict TypeScript interfaces for all component props.
3. Prioritize performance: ensure proper hydration boundaries and prevent unnecessary re-renders.
4. Do not touch backend logic, database layers, or routing. If a task requires these, report the limitation back to the Lead Agent immediately.
```

By decoupling the tools and restrictions this way, you can easily spin up a parallel `.claude/agents/code-reviewer.md` that has `read-only` file access and only holds permission to run your local linter.

## Coordinating with Explicit Workflows

While letting a Lead Agent dynamically discover and chat with sub-agents via *semantic routing* works great for ad-hoc coding questions, complex tasks—like refactoring a feature or generating a brand-new module—require deterministic predictability.

This is where explicit orchestration workflows come into play. By defining a pipeline file like `workflows.yaml`, you map out the exact chain reaction your squad must follow, allowing steps to run **parallelly** when there are no dependencies.

```yaml
workflows:
  - name: GenerateAndValidateFeature
    trigger: "Create a new dashboard view"
    orchestration_mode: parallel_with_dependencies
    steps:
      - step_id: build_ui
        agent: agents/ui-architect.md
        action: "Generate the presentation layer and React components based on the user prompt."
      
      - step_id: lint_code
        agent: agents/oxlint-reviewer.md
        depends_on: [build_ui] 
        action: "Analyze the generated files using local static analysis tools."

      - step_id: security_audit
        agent: agents/security-auditor.md
        depends_on: [build_ui] 
        action: "Scan the generated UI code parallelly for XSS vulnerabilities and insecure state mutations."
```

When this workflow executes, the Lead Agent coordinates the lifecycle. It provisions the `ui-architect`, grabs its output, and spins up both the `oxlint-reviewer` and the `security-auditor` at the same time. They analyze the code from two entirely different perspectives, catch errors individual generalist chats would completely miss, and report their unified feedback back to your editor.

## The Paradigm Shift

We are moving away from treating AI as an autocomplete box or a single conversational partner. Software development is shifting toward **workflow architecture**.

By breaking down your internal development guidelines, linters, and local RAG databases into discrete tools, and wrapping your LLMs in focused sub-agent firewalls, you effectively stop prompt engineering. Instead, you start managing a highly optimized, deterministic, automated development squad right from your workspace.

</div>
