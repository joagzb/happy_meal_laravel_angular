export function getFoodWithEmoji(food: string): string {
  const foodEmojis: { [key: string]: string } = {
    tomato: "🍅",
    lemon: "🍋",
    potato: "🥔",
    rice: "🍚",
    ketchup: "🍅",
    lettuce: "🥬",
    onion: "🧅",
    cheese: "🧀",
    meat: "🍖",
    chicken: "🍗",
  };

  const emoji = foodEmojis[food.toLowerCase()];

  return emoji ? `${emoji} ${food}` : food;
}