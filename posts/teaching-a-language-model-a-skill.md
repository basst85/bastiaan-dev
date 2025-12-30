---
title: "Teaching a language model a skill (using poker as an example)"
published: true
publish_date: 2025-12-30 22:00
updated_date: 2025-12-30 22:45
author: Bastiaan
intro: "When prompting starts to hallucinate, fine-tuning is often the step that turns a clever language model into a system you can actually trust."
tags: development,llm,ollama,fine-tunen,artificial-intelligence
min_read: 15
header_image: /images/from-text-to-vectors.jpg
---
<div class="w-full blogpost-content">

## Introduction
There’s a moment in every LLM project where the vibe changes.

At first, everything is “wow”. You write a prompt, you get a coherent answer, and it feels like you’re already halfway to shipping. Then you ask the model to do something specific and repeatable.

You notice it when:

- a support bot confidently invents a refund policy that doesn’t exist  
- a legal or medical summarizer uses beautiful language while quietly changing meaning  
- an internal assistant gives answers that sound right, but can’t be tested reliably  
- a poker coach gives “reasonable” advice, while **hallucinating** stack sizes, actions, or ranges  

That’s when prompting starts to feel like negotiating, and you begin looking for something sturdier.
This is where fine-tuning becomes interesting.

Poker is a useful case study because it’s a domain where “plausible” is not enough. It’s a decision problem with hard constraints, hidden information, and lots of near-identical situations where consistency matters.

And there’s a dataset for it.

## Prompting, retrieval, and fine-tuning

Most real systems end up with one of these three patterns.

### Prompting

Prompting is the lightest approach: you tell the model what you want and hope it generalizes. Sometimes you add a few examples.

It’s fast. It’s great for prototyping. But it’s also where hallucinations thrive, because the model is doing what it was trained to do: generate plausible continuations.


### RAG
Retrieval-Augmented Generation (RAG) is “search first, answer second”. You keep knowledge outside the model, retrieve relevant chunks at runtime, and feed them in as context.

RAG is excellent for fast-changing knowledge bases: policies, docs, product catalogs. It’s less great when you need *behavioral consistency* (for example “always output an action + bet size in a strict format”) because retrieval changes the context, not the default reasoning style.

If you want a practical mental model for why RAG works at all, it helps to understand embeddings and vector search. That’s exactly what’s covered in:
[https://bastiaan.dev/blog/from-text-to-vectors](https://bastiaan.dev/blog/from-text-to-vectors)

### Fine-tuning
Fine-tuning changes the model.
Instead of repeatedly reminding the model what “correct” looks like, you train it on enough examples that correct behavior becomes default. It won’t magically eliminate hallucinations—but it can reduce them by narrowing the space of possible answers and reinforcing your desired output style.

Poker is one of those domains where this matters.

## Why poker breaks generic models quickly
A generic LLM can talk about poker concepts. Position, pot odds, and bluffing are no problem.

But ask it to act:
> “Here’s the hand history. What do we do now? Fold/call/raise.”

That’s where you’ll see:

- invented betting actions  
- inconsistent lines between similar hands  
- “confident strategy” that collapses under scrutiny  
- hallucinated details that weren’t in the prompt  

PokerBench exists because poker is a strong stress test for LLM decision-making: it’s incomplete-information, strategically complex, and easy to evaluate when you have solver labels.

PokerBench dataset:
[https://huggingface.co/datasets/RZ412/PokerBench](https://huggingface.co/datasets/RZ412/PokerBench)
[https://github.com/pokerllm/pokerbench](https://github.com/pokerllm/pokerbench)  

## Choosing the right base model for a real-time poker coach
In practice, you’ll be choosing between:

1. a small model (~3B) that’s fast and “good enough” after fine-tuning  
2. a mid-sized model (~7B–8B) that’s slower but more stable in edge cases  

### Option A: Llama 3.2 3B Instruct (fastest modern baseline)
A strong small model with good instruction-following for its size. Works well with strict output formats and LoRA fine-tuning.

Model page:
[https://huggingface.co/meta-llama/Llama-3.2-3B-Instruct](https://huggingface.co/meta-llama/Llama-3.2-3B-Instruct)

### Option B: Mistral 7B Instruct
Efficient, widely used, and explicitly designed to be fine-tuned. This is often the size where poker advice starts feeling consistent under pressure.

Model page:
[https://huggingface.co/mistralai/Mistral-7B-Instruct-v0.3](https://huggingface.co/mistralai/Mistral-7B-Instruct-v0.3)

### Option C: Qwen2.5 7B Instruct
Especially interesting if you want longer hand histories or structured outputs.

Model page:
[https://huggingface.co/Qwen/Qwen2.5-7B-Instruct](https://huggingface.co/Qwen/Qwen2.5-7B-Instruct)

## What you actually need to fine-tune a poker coach
Fine-tuning isn’t one thing, it’s a pipeline.

### 1. Data
You need examples of the behavior you want.

PokerBench provides natural language prompts paired with optimal actions, already split into train and test sets.

Key decisions you still need to make:

- action only vs. action + sizing  
- include rationale or not  
- enforce a strict output format

For real-time usage, a strict output contract is worth it.

### 2. Base model and chat template
Instruction-tuned models expect a specific chat format. Mismatched templates lead to subtle failures: role drift, formatting errors, or verbose answers when you want a single action.

Always fine-tune using the model’s native chat template.

### 3. Fine-tuning method
Full fine-tuning is rarely necessary.

Most teams use **LoRA** or **QLoRA**:

- LoRA: small trainable adapters on top of frozen weights  
- QLoRA: similar, but optimized for lower memory usage  

LoRA guide with examples:  
[https://huggingface.co/docs/peft/main/en/developer_guides/lora](https://huggingface.co/docs/peft/main/en/developer_guides/lora)

### 4. Training tooling
A common modern stack:

- Hugging Face Transformers  
- Hugging Face Datasets  
- PEFT  
- TRL’s `SFTTrainer`

SFTTrainer docs with examples:  
[https://huggingface.co/docs/trl/main/en/sft_trainer](https://huggingface.co/docs/trl/main/en/sft_trainer)


PyTorch blog (with Colab notebook):  
[https://pytorch.org/blog/finetune-llms/](https://pytorch.org/blog/finetune-llms/)


Unsloth (fast fine-tuning, consumer hardware):  
[https://www.unsloth.ai/blog/llama3](https://www.unsloth.ai/blog/llama3)


### Ollama API
Once running, your poker coach is just another HTTP service (API).

API docs:
[https://github.com/ollama/ollama/blob/main/docs/api.md](https://github.com/ollama/ollama/blob/main/docs/api.md)

## Fine-tuning and hallucinations
Fine-tuning doesn’t turn hallucinations off.
What it does:

- narrows the output space
- reinforces domain-correct patterns
- makes behavior testable and repeatable

The most robust setups combine:

- fine-tuned behavior  
- strict output validation  
- optional retrieval for table or player context  


## Conclusion

Fine-tuning isn’t about making models smarter.
It’s about making them predictable, reducing hallucination risk, and aligning behavior with real-world constraints.

Poker just makes that lesson obvious.

If your system needs to *decide*, not just explain, fine-tuning is often the difference between a clever demo and something you can actually trust.


## References and further reading
<a href="https://www.digitalocean.com/community/tutorials/llm-finetuning-domain-specific-models" target="_blank">LLM Fine-Tuning: A Guide for Domain-Specific Models</a>

<a href="https://medium.com/@jamestang/fine-tuning-llms-for-specific-domains-why-how-and-what-to-consider-8b2fd5781615" target="_blank">Fine-Tuning LLMs for Specific Domains: Why, How, and What to Consider</a>

</div>