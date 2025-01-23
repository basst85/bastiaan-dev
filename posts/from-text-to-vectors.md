---
title: "From Text to Vectors: A Practical Guide to Semantic Search"
published: true
publish_date: 2025-01-22 21:00
updated_date: 2025-01-22 21:55
author: Bastiaan
intro: "In this post, I'll walk you through the process of building a semantic search engine using SQLite and OpenAI's API."
tags: development,vector search,sqlite,openai
min_read: 10
header_image: /images/from-text-to-vectors.jpg
---
## Introduction
Traditional search engines often rely on matching keywords. This can be limiting, as searches might miss relevant information that doesn't use the exact words you entered. Semantic search aims to overcome this limitation by understanding the meaning behind your query. Instead of just looking for specific words, it tries to find information that is semantically similar to what you're looking for.

## The Power of Vectors
Imagine representing words and sentences as points in a multi-dimensional space. Words with similar meanings would be closer together in this space. Vector search uses this concept. It converts text into mathematical representations called vectors. These vectors capture the meaning of the text, allowing the search engine to find information that is conceptually similar to your query, even if it doesn't use the same words.

## Example uses of Semantic Search
Semantic search has many applications. For example, it can be used to:
- **Product search:** Find products that are similar to what you're looking for, even if they use different words.
- **Content recommendation:** Suggest articles, videos, or products that are related to what you've read or watched.
- **Question answering:** Retrieve answers to questions based on the meaning of the query, not just the keywords.
- **Chatbots:** Understand the intent behind user messages and provide relevant responses.

## How Semantic Search works
Semantic search engines typically follow these steps:
1. **Vectorization:** Convert the text into vectors using a language model or embedding technique.
2. **Storage:** Store the generated embedding vectors in a database.
3. **Query processing:** Convert the query into a vector and compare it to the indexed vectors to find the most similar ones.
4. **Ranking:** Rank the results based on their similarity to the query.

## What you'll need
To build a semantic search engine, we need:
1. A way to convert text into vectors: We'll use OpenAI's API, which provides a powerful language model that can generate vector embeddings for text.
2. The model we'll use is called `text-embedding-3-small`. We limited the dimensions to 1000 to keep the vectors small and efficient.
3. A database to store our text data: In this guide, we'll use SQLite, a lightweight database that is easy to set up and use.

## Building a Semantic Search Engine
In this guide, we'll build a simple semantic search engine using SQLite and OpenAI's API. SQLite is a lightweight database that we'll use to store our text data. OpenAI's API provides a powerful language model that can generate vector **embeddings** for our text. By combining these tools, we can create a semantic search engine that can find relevant information based on the meaning of the query.

![Infographic Vector Search](/images/infographic-vector-search.jpg)

## Code example in JavaScript

```javascript
import sqlite3 from 'sqlite3';
import OpenAI from 'openai';

// Load environment variables from .env file
const openai = new OpenAI({
    apiKey: process.env.OPENAI_API_KEY
});

// Connect to SQLite database
const db = new sqlite3.Database('embeddings.db', (err) => {
    if (err) {
        console.error(err.message);
    }
});

// Create table to store embeddings, if it does not exist
db.run(`
CREATE TABLE IF NOT EXISTS embeddings (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    text TEXT,
    embedding BLOB
)
`);

// Function to create and save an embedding
async function saveEmbedding(text) {
    const response = await openai.embeddings.create({
        model: "text-embedding-3-small",
        input: text,
        dimensions: 1000
    });

    const embedding = response.data[0].embedding;

    db.run('INSERT INTO embeddings (text, embedding) VALUES (?, ?)', [text, JSON.stringify(embedding)], (err) => {
        if (err) {
            console.error(err.message);
        }
    });
}

// Function to search for embeddings
async function searchEmbedding(query) {
    // First create an embedding for the query
    const queryEmbedding = await openai.embeddings.create({
        model: "text-embedding-3-small",
        input: query,
        dimensions: 1000
    });

    // Then retrieve all embeddings from the database
    db.all('SELECT * FROM embeddings', async (err, rows) => {
        if (err) {
            console.error(err);
            return;
        }

        // Function to calculate the dot product of two vectors
        function dotProduct(v1, v2) {
            return v1.reduce((sum, value, i) => sum + value * v2[i], 0);
        }

        // Calculate the similarity (dot product) of the query embedding with each row
        const results = rows.map(row => {
        const embedding = JSON.parse(row.embedding);
        const similarity = dotProduct(queryEmbedding.data[0].embedding, embedding);

        return {
            id: row.id,
            text: row.text,
            score: similarity
        };
        });

        // Sort the results by similarity score and display the top 2
        results.sort((a, b) => b.score - a.score);
        const topResults = results.slice(0, 2);

        console.log(topResults);
    });
}

// Example usage. Create and save embeddings for some Pokémon
saveEmbedding("Pikachu: This iconic electric-type Pokémon is known for its cheerful personality and its powerful electric attacks, such as Thunderbolt and Quick Attack. Pikachu is a fan favorite and has become a symbol of the Pokémon franchise.");
saveEmbedding("Charizard: This fire-type Pokémon is known for its fierce appearance and its powerful fire attacks, such as Flamethrower and Fire Spin. Charizard is a popular choice among trainers and is often considered one of the strongest Pokémon in battle.");
saveEmbedding("Bulbasaur: This grass-type Pokémon is known for its bulb on its back, which grows into a large plant as it evolves. Bulbasaur is a friendly and loyal Pokémon that is often chosen by new trainers as their first Pokémon.");
saveEmbedding("Squirtle: This water-type Pokémon is known for its blue skin and its powerful water attacks, such as Water Gun and Hydro Pump. Squirtle is a playful and mischievous Pokémon that is often seen wearing sunglasses.");
saveEmbedding("Jigglypuff: This normal/fairy-type Pokémon is known for its round shape and its ability to put others to sleep with its soothing song. Jigglypuff is a cute and friendly Pokémon that is often seen in Pokémon contests.");
saveEmbedding("Meowth: This normal-type Pokémon is known for its mischievous behavior and its ability to speak human language. Meowth is a clever and cunning Pokémon that is often seen working with Team Rocket to steal other Pokémon.");
saveEmbedding("Mewtwo: This psychic-type Pokémon is known for its incredible psychic powers and its fierce appearance. Mewtwo is a legendary Pokémon that was created through genetic manipulation and is considered one of the most powerful Pokémon in existence.");
saveEmbedding("Gengar: This ghost/poison-type Pokémon is known for its mischievous behavior and its ability to hide in the shadows. Gengar is a playful and cunning Pokémon that is often seen playing pranks on other Pokémon.");
saveEmbedding("Snorlax: This normal-type Pokémon is known for its large size and its ability to sleep for long periods of time. Snorlax is a lazy and relaxed Pokémon that is often seen blocking paths and causing trouble for trainers.");
saveEmbedding("Pidgeot: This normal/flying-type Pokémon is known for its large wings and its ability to fly at high speeds. Pidgeot is a majestic and powerful Pokémon that is often seen leading flocks of other bird Pokémon.");

// Search for embeddings similar to a query
searchEmbedding("Looks like a turtle");
```

## Conclusion
The code above demonstrates how to create and save embeddings for Pokémon descriptions and then search for embeddings similar to a query.
It searches for embeddings similar to the query "Looks like a turtle" and displays the top 2 results. The number one result is Squirtle, a water-type Pokémon that looks like a turtle.

![Example script result](/images/result-vector-search.png)

By using semantic search, we can find relevant information based on the meaning of the query, not just the keywords. This approach can be applied to a wide range of applications, from product search to content recommendation and question answering. I hope this guide has given you a practical understanding of how semantic search works and how you can build your own semantic search engine using SQLite and OpenAI's API.

## References and further reading
<a href="https://www.pinecone.io/learn/vector-embeddings-for-developers" target="_blank">Vector Embeddings for Developers</a>

<a href="https://huggingface.co/spaces/jphwang/colorful_vectors" target="_blank">Colorful Vectors</a>

<a href="https://platform.openai.com/docs/api-reference/embeddings" target="_blank">OpenAI API</a>

<a href="https://www.sqlite.org/index.html" target="_blank">SQLite</a>

<a href="https://en.wikipedia.org/wiki/Semantic_search" target="_blank">Semantic Search</a>

<a href="https://en.wikipedia.org/wiki/Vector_space_model" target="_blank">Vector Search</a>
