---
code: null
id: I_kwDOGkiayc5IzQAc
databaseId: 1221394460
number: 2
url: https://github.com/octolab/observer/issues/2
title: "experimental: map based classifier"
issueType: null
labels: []
assignees:
  - kamilsk
milestone: null
parent: null
issueFields: {}
state: OPEN
stateReason: null
duplicateOf: null
createdAt: 2022-04-29T18:39:06Z
updatedAt: 2022-04-29T18:39:26Z
lastEditedAt: null
closedAt: null
---

# experimental: map based classifier

```php
class ActionContext
{
    public function __construct(
        public readonly Flow $flow,
        public readonly Severity $severity,
        public readonly ?bool $useErrorMessage = null,
        public readonly ?string $message = null,
        public readonly ?string $metric = null,
    ) {
    }
}



class BaseClassifier implements \OctoLab\Observer\Payload\Classifier
{
    private array $actions = [];

    public function extend(string $fqcn, ActionContext $actionContext): void
    {
        if (!class_exists($fqcn) && !interface_exists($fqcn)) {
            throw new UnknownClassnameException($fqcn);
        }

        $this->actions[$fqcn] = $actionContext;
    }

    public function classify(\Throwable $error): Type\Action
    {
        return match (true) {
            $this->extendedActionExists($error) => $this->getExtendedAction($error),
            default => new Type\Action(
                $error,
                Type\Flow::throw,
                severity: Type\Severity::Error,
                message: $error->getMessage(),
                metric: Metrics::NOT_CLASSIFIED_ERROR,
            ),
        };
    }

    private function extendedActionExists(\Throwable $error): bool
    {
        return $this->getActionContext($error) !== null;
    }

    private function getActionContext(\Throwable $error): ?ActionContext
    {
        if (isset($this->actions[$error::class])) {
            return $this->actions[$error::class];
        }

        foreach (class_implements($error) as $interfaceName) {
            if (isset($this->actions[$interfaceName])) {
                return $this->actions[$interfaceName];
            }
        }

        return null;
    }

    private function getExtendedAction(\Throwable $error): Type\Action
    {
        $actionContext = $this->getActionContext($error);

        return new Type\Action(
            $error,
            $actionContext->flow,
            $actionContext->severity,
            $actionContext->useErrorMessage ? $error->getMessage() : $actionContext->message,
            $actionContext->metric,
        );
    }
}


class DomainClassifier implements \OctoLab\Observer\Payload\Classifier
{
    public function __construct(private BaseClassifier $classifier)
    {
        $this->classifier->extend(
            DomainException\Exception::class,
            new ActionContext(
                flow: Type\Flow::ignore,
                severity: Type\Severity::Info,
                useErrorMessage: true,
                metric: Metrics::GHERKIN_PARSER_ERROR,
            ),
        );
    }

    public function classify(\Throwable $error): Type\Action
    {
        return $this->classifier->classify($error);
    }
}
```
