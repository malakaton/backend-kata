<?php

declare(strict_types=1);

namespace App\Product\EntryPoint\UI\Command;

use App\Product\Application\Product\FeedParser\ProductFeedParserCommand;
use App\Product\Domain\Product\Product;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class ProductsParsing extends Command
{
    /**@var static string $defaultName **/
    protected static $defaultName = 'app:products-parsing';

    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var HandledStamp $envelope */
        $envelope = $this->commandBus->dispatch(new ProductFeedParserCommand())->last(HandledStamp::class);

        foreach ($envelope->getResult() as $product) {
            /**@var Product $product **/
            $output->write(
                PHP_EOL . "<fg=black;bg=green><fg=black;bg=red>title:</> {$product->title()->value()}, </>"
            );
            $output->write("<fg=black;bg=green><fg=black;bg=red>id:</> {$product->id()->value()}, </>");
            $output->write(
                "<fg=black;bg=green><fg=black;bg=red>date:</> {$product->pubDate()->toFormatDate()}, </>"
            );
            $output->writeln("<fg=black;bg=green><fg=black;bg=red>url:</> {$product->link()->value()}</>");
        }
        $output->write(PHP_EOL);

        return Command::SUCCESS;
    }
}